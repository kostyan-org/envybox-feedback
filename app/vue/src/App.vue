<script>
export default {
  data() {
    return {
      name: '',
      phone: '',
      text: '',
      answer: false,
      pending: false,
      error: '',
      success: ''
    }
  },
  methods: {
    send() {
      this.pending = true
      this.answer = false
      this.success = ''
      this.error = ''
      fetch("/api",
          {method: "POST",headers: {"Content-Type": "application/json"}, body: JSON.stringify(this.$data)})
          .then((response) => response.json())
          .then((data) => {
            this.answer = true
            this.pending = false
            this.success = data
            this.error = ''
            if (data.violations) {
              throw new Error(data.detail);
            }
            this.text = ''
            console.log("Success: ", data);
          })
          .catch((error) => {
            this.answer = true
            this.pending = false
            this.error = error
            this.success = ''
            console.error("Error: ", error);
          });
    }
  }
}
</script>

<template>
  <form action="/api" method="post" class="form">
    <div class="menu">
      <a href="http://localhost:8080">MySql</a>
      <a href="/files/feedback.txt">File</a>
    </div>
    <h1>Форма обратной связи</h1>
    <div class="field-name">
      <label for="name">Имя<span class="required">*</span></label>
      <input type="text"
             placeholder="Иван"
             class="form-control"
             name="name"
             maxlength="255"
             id="name"
             required="required"
             aria-required="true"
             :disabled="pending"
             v-model="name">
    </div>
    <div class="field-phone">
      <label for="phone">Телефон<span class="required">*</span></label>
      <input type="text"
             placeholder="+79995554411"
             class="form-control"
             name="phone"
             maxlength="12"
             id="phone"
             required="required"
             aria-required="true"
             :disabled="pending"
             v-model="phone">
    </div>
    <div class="field-text">
      <label for="text">Текст<span class="required">*</span></label>
      <textarea type="textarea"
                class="form-control"
                name="text"
                maxlength="1024"
                rows="4"
                id="text"
                required="required"
                aria-required="true"
                :disabled="pending"
                v-model="text"></textarea>
    </div>
    <div class="field-button">
      <button type="button"
              class="btn"
              name="button"
              id="button"
              :disabled="pending"
              @:click="send($event)">
        Отправить
      </button>
    </div>
  </form>
  <transition name="fade">
    <div class="answer"
         v-if="answer"
         :class="{ 'error': error, 'success': success }">
      <div v-if="error">
        <h3>Ошибка</h3>
        <pre>{{error}}</pre>
      </div>
      <div v-if="success">
        <h3>Ответ:</h3>
        <pre>{{success}}</pre>
      </div>
    </div>
  </transition>
</template>

<style scoped>
.menu {
  display: flex;
  flex-direction: row;
  flex-wrap: wrap;
  justify-content: space-between;
}
.menu a {
  display: flex;
}
.form {
  display: flex;
  flex-wrap: wrap;
  flex-direction: column;
  max-width: 800px;
  margin: 0 auto;
  font-family: Arial;
  font-size: 1rem;
  color: darkslategrey;
}
.form-control {
  padding: 0.4rem;
}
.btn {
  padding: 1rem;
  background: aliceblue;
}
.field-button, .field-name, .field-phone, .field-text, h1 {
  display: flex;
  flex-direction: column;
  margin-bottom: 1rem;
}
.required {
  color: crimson;
  font-weight: bold;
}
.answer {
  max-width: 800px;
  margin: 0 auto;
  font-family: Arial;
  font-size: 1rem;
  padding: 0.5rem;
}
.success {
  background: #00bd7e;
  color: white;
}
.error {
  background: crimson;
  color: white;
}
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
