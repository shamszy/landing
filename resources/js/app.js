import {createApp} from 'vue/dist/vue.esm-bundler'
import Application from './App.vue'
import Router from './router'
import Store from  './store'

const app = createApp({});

app.component('app', Application);
app.use(Router);
app.use(Store)
app.mount('#app');


let i = 1;

  function nextSlide(){
    if(i == 3){
      let activeSlide = document.querySelector('.slide.translate-x-0');
      activeSlide.classList.remove('translate-x-0');
      activeSlide.classList.add('translate-x-full');

      let nextSlide = activeSlide.previousElementSibling.previousElementSibling;
      nextSlide.classList.remove('translate-x-full');
      nextSlide.classList.add('translate-x-0');

      i = 1;
    }
    else{
      i++;

      let activeSlide = document.querySelector('.slide.translate-x-0');
      activeSlide.classList.remove('translate-x-0');
      activeSlide.classList.add('translate-x-full');

      let nextSlide = activeSlide.nextElementSibling;
      nextSlide.classList.remove('translate-x-full');
      nextSlide.classList.add('translate-x-0');
  }

  }

  function previousSlide(){
    if(i == 1){
      let activeSlide = document.querySelector('.slide.translate-x-0');
      activeSlide.classList.remove('translate-x-0');
      activeSlide.classList.add('translate-x-full');

      let previousSlide = activeSlide.nextElementSibling.nextElementSibling;
      previousSlide.classList.remove('translate-x-full');
      previousSlide.classList.add('translate-x-0');

      i = 3;
    }
    else{
      i--;

      let activeSlide = document.querySelector('.slide.translate-x-0');
      activeSlide.classList.remove('translate-x-0');
      activeSlide.classList.add('translate-x-full');

      let previousSlide = activeSlide.previousElementSibling;
      previousSlide.classList.remove('translate-x-full');
      previousSlide.classList.add('translate-x-0');
    }
  }