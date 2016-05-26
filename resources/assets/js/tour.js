$(document).ready(function () {
    var step1 = {
        element: $('.tvList .panel-title:first>a:first'),
        content: 'Click on title to show TV details',
        onShown: function (tour) {
            if (!this.element.attr('aria-expanded')) {
                this.element.one('click', function () {
                    tour.next();
                })
            }
        },
        onNext: function () {
            if (!this.element.attr('aria-expanded')) {
                step1.element.click();
            }
        }
    };
    var step2 = {
        element: step1.element.closest('.panel-heading').next().find('span .glyphicon-link'),
        content: 'Click icon to see episodes'
    };
    var step3 = {
        element: step1.element.next(),
        content: 'Click box to subscribe'
    };

    var tv_tour_guide = new Tour({
        name: 'tourDemo',
        steps: [step1, step2, step3]
    });
    tv_tour_guide.init()
        .start();
});
