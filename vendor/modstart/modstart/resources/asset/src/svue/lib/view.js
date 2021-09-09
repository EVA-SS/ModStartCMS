import $ from 'jquery'

const ViewUtil = {
    setHeightResponsively(context, name, minHeight, heightCalculator) {
        minHeight = minHeight || 200
        const resize = () => {
            let height
            try {
                height = heightCalculator()
            } catch (e) {
                console.log('error', e)
            }
            if (!height) {
                height = minHeight
            }
            context[name] = Math.max(height, minHeight)
        }
        setTimeout(() => resize(), 100)
        $(window).on('resize', resize)
    },
    windowHeight() {
        return $(window).height()
    },
    fireResize() {
        $(window).trigger('resize')
    }
}


export {
    ViewUtil
}
