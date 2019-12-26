
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('workout-details', require('./components/WorkoutDetails.vue'));
Vue.component('workout-list', require('./components/WorkoutList.vue'));
Vue.component('workout-filter', require('./components/WorkoutFilter.vue'));
Vue.component('workout-list-item', require('./components/WorkoutListItem.vue'));

export const eventBus = new Vue();

$(document).ready(function(){


	const app = new Vue({
		el: '#app',
		data: {
			workouts: []
		}
	});
});

