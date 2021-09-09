const jquery = require('jquery');
const Base = require('./../lib/basePC');
const Dialog = require('./../lib/dialogPC');
const Lister = require('./../lib/lister');
const Util = require('./../lib/util');
const SelectorDialog = require('./../lib/selectorDialog');

const MS = {
    ready() {
        let args = Array.from(arguments)
        const cb = args.pop()
        let passed = true
        for (let f of args) {
            switch (typeof f) {
                case 'function':
                    if (!f()) passed = false
                    break
                default:
                    if (!f) passed = false
            }
            if (!passed) break
        }
        if (!passed) {
            setTimeout(() => {
                MS.ready.call(this, ...arguments)
            }, 50)
            return
        }
        cb()
    },
    dialog:Dialog,
    util:Util,
    api:{
        post:Base.post
    }
}

window.api = window.api || {}

window.api.jquery = jquery
window.api.base = Base
window.api.dialog = Dialog
window.api.lister = Lister
window.api.selectorDialog = SelectorDialog
window.api.util = Util

Base.init()

window.MS = MS
