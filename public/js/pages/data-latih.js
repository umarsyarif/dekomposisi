/**
 * init
 */
function initVue() {
    var vm = new Vue({
        el: '#app',
        data: {
            return: {
                asd: 'asd'
            }
        },
        mounted: function () {
            //
        },
        components: {
            //
        }
    });
}

try {
    initVue();
} catch (e) {
    // window.location.reload();
}
