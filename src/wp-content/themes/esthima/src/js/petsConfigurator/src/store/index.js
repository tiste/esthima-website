import { createStore } from 'vuex'
import petsConfigurator from './modules/petsConfigurator'
import VuexPersistence from 'vuex-persist'
import Cookie from 'js-cookie'
import Crypto from 'crypto-js';


const debug = process.env.NODE_ENV !== 'production'

const cookieName = 'petsConfigurator' 

const storageKey = 'petsConfigurator'

const vuexCookie = new VuexPersistence({
	key: cookieName,
	restoreState: (key, storage) => Cookie.getJSON(key),
	saveState: (key, state, storage) => Cookie.set(key, state, {
		expires: 3
	})
})

// // Get the encryption token from cookie or generate a new one.
// const encryptionToken = Cookie.get(cookieName) || Crypto.SHA256("petsConfigurator").toString();

// // Store the encryption token in a secure cookie.
// Cookie.set(cookieName, encryptionToken, { secure: true, expires: 180 });

// const vuexLocal = new VuexPersistence({
//   storage: {
//     getItem: () => {
//       // Get the store from local storage.
//       const store = window.localStorage.getItem(storageKey);

//       if (store) {
//         try {
//           // Decrypt the store retrieved from local storage
//           // using our encryption token stored in cookies.
//           const bytes = Crypto.AES.decrypt(store, encryptionToken);

//           return JSON.parse(bytes.toString(Crypto.enc.Utf8));
//         } catch (e) {
//           // The store will be reset if decryption fails.
//           window.localStorage.removeItem(storageKey);
//         }
//       }

//       return null;
//     },
//     setItem: (key, value) => {
//       // Encrypt the store using our encryption token stored in cookies.
//       const store = Crypto.AES.encrypt(value, encryptionToken).toString();

//       // Save the encrypted store in local storage.
//       return window.localStorage.setItem(storageKey, store);
//     },
//     removeItem: () => window.localStorage.removeItem(storageKey),
//   },
// });

export default createStore({
	modules: {
	  petsConfigurator
	},
	strict: debug,
	plugins: [vuexCookie.plugin]
})