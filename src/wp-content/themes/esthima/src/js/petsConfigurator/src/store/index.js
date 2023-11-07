import Vue from 'vue'
import Vuex from 'vuex'
import VuexPersistence from 'vuex-persist/dist/umd'
import Cookie from 'js-cookie'
import Crypto from 'crypto-js';


Vue.use(Vuex)

// const vuexCookie = new VuexPersistence({
// 	key: 'petsConfigurator',
// 	restoreState: (key, storage) => Cookies.getJSON(key),
// 	saveState: (key, state, storage) => Cookies.set(key, state, {
// 		expires: 3
// 	})
// })

const debug = process.env.NODE_ENV !== 'production'

const cookieName = 'petsConfigurator'

const storageKey = 'petsConfigurator'

// Get the encryption token from cookie or generate a new one.
const encryptionToken = Cookie.get(cookieName) || Crypto.SHA256("petsConfigurator").toString();

// Store the encryption token in a secure cookie.
Cookie.set(cookieName, encryptionToken, { secure: true, expires: 180 });

const vuexLocal = new VuexPersistence({
  storage: {
    getItem: () => {
      // Get the store from local storage.
      const store = window.localStorage.getItem(storageKey);

      if (store) {
        try {
          // Decrypt the store retrieved from local storage
          // using our encryption token stored in cookies.
          const bytes = Crypto.AES.decrypt(store, encryptionToken);

          return JSON.parse(bytes.toString(Crypto.enc.Utf8));
        } catch (e) {
          // The store will be reset if decryption fails.
          window.localStorage.removeItem(storageKey);
        }
      }

      return null;
    },
    setItem: (key, value) => {
      // Encrypt the store using our encryption token stored in cookies.
      const store = Crypto.AES.encrypt(value, encryptionToken).toString();

      // Save the encrypted store in local storage.
      return window.localStorage.setItem(storageKey, store);
    },
    removeItem: () => window.localStorage.removeItem(storageKey),
  },
});

export default new Vuex.Store({
	modules: {
	  petsConfigurator
	},
	strict: debug,
	plugins: [vuexLocal.plugin]
})