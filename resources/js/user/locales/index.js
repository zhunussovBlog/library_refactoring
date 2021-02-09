import Vue from 'vue'
import VueI18n from 'vue-i18n'
import en from './en.json'
import ru from './ru.json'
import kz from './kz.json'

const languages = {
	en:en,
	ru:ru,
	kz:kz
}

const messages = Object.assign(languages)

Vue.use(VueI18n)

export default new VueI18n({
	locale: 'en',
	messages,
	silentTranslationWarn: true
})