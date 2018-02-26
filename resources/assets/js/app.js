
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');
require('sweetalert');

window.Vue = require('vue');
var Web3 = require('web3');

if (typeof web3 !== 'undefined') {
  window.web3 = new Web3(web3.currentProvider);
} else {
  // set the provider you want from Web3.providers
  window.web3 = new Web3(new Web3.providers.HttpProvider("https://mainnet.infura.io/P5iyGV9tixji8mEvl8QB"));
}

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component(
	'create-wallet-component', 
	require('./components/CreateWalletComponent.vue')
);

Vue.component(
  'rigs-component', 
  require('./components/RigsComponent.vue')
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue')
);

const app = new Vue({
    el: '#app'
});
