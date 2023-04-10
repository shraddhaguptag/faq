<template>
  <h1>Freqently Asked Question </h1>
  <div class="container">

  <div class="row justify-content-center">
    <div class="col-lg-10 col-md-10" v-for="(category, index) in questions.data" :key="index" v-bind:key="category.id">     
      <h2 > <b>{{ category[0].category.name }}</b></h2>
      <div class="tabs">
        <div class="tab" v-for="faq in category">
          <input type="checkbox"  v-bind:id="'chck'+faq.id">
          <label class="tab-label" v-bind:for="'chck'+faq.id">{{faq.title}}</label>
          <div class="tab-content">
            <p v-html="faq.answer"></p>
          </div>
        </div>
      </div>
      <br/> <br/> 
    </div>
    
  </div>
  </div>
</template>

<script>
export default {
  name: 'FAQ',

  data() {
    return {
      questions: [],
    }
  },
  created() {
    this.getList();
  },

  methods: {
    async getList() {
            await axios.get('/api/faq').then(response => {
                this.questions = response.data;
            }).catch(error => {
                console.log(error)
                this.questions = [];
            })
            console.log(this.questions)
        },
  }
}
</script>

<style>
body {
  color: #2c3e50;
  background: #ecf0f1;
  padding: 0 1em 1em;
}

h1 {
  margin: 0;
  line-height: 2;
  text-align: center;
}

h2 {
  margin: 0 0 0.5em;
  font-weight: normal;
}

input {
  position: absolute;
  opacity: 0;
  z-index: -1;
}

.row {
  display: flex;
}

.row .col {
  flex: 1;
}

.row .col:last-child {
  margin-left: 1em;
}

/* Accordion styles */
.tabs {
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 4px 4px -2px rgba(0, 0, 0, 0.5);
}

.tab {
  width: 100%;
  color: white;
  overflow: hidden;
}

.tab-label {
  display: flex;
  justify-content: space-between;
  padding: 1em;
  background: #2c3e50;
  font-weight: bold;
  cursor: pointer;
  /* Icon */
}

.tab-label:hover {
  background: #1a252f;
}

.tab-label::after {
  content: "\276F";
  width: 1em;
  height: 1em;
  text-align: center;
  transition: all 0.35s;
}

.tab-content {
  max-height: 0;
  padding: 0 1em;
  color: #2c3e50;
  background: white;
  transition: all 0.35s;
}

.tab-close {
  display: flex;
  justify-content: flex-end;
  padding: 1em;
  font-size: 0.75em;
  background: #2c3e50;
  cursor: pointer;
}

.tab-close:hover {
  background: #1a252f;
}

input:checked+.tab-label {
  background: #1a252f;
}

input:checked+.tab-label::after {
  transform: rotate(90deg);
}

input:checked~.tab-content {
  max-height: 100vh;
  padding: 1em;
}</style>
