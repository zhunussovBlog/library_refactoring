export const goTo = {
    methods: {
        goTo(place, props) {
            let lang = this.$i18n.locale;
            if (place != 'home') {
                this.$router.push({ path: '/' + lang + '/' + place, query: props });
            } else {
                this.$router.push({ path: '/' + lang, query: props });
            }
            this.$emit('close');
        }
    }
}
export const scrollTo = {
    methods: {
        scrollTo(link, yOffset) {
            try {
                var yLen = yOffset || 0;
                const element = document.getElementById(link);
                const y = element.getBoundingClientRect().top + window.pageYOffset + yLen;
                window.scrollTo({ top: y, behavior: 'smooth' });
            } catch (e) {}
        }
    }
}