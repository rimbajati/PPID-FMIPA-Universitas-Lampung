<script>
    function incrementCounter(id) {
        var el = document.getElementById('click-count-' + id);
        if (el) {
            var currentVal = parseInt(el.innerText.replace(/[^0-9]/g, '')) || 0;
            var newVal = currentVal + 1;
            el.innerText = newVal.toLocaleString('id-ID');
        }
    }

    document.addEventListener('click', function(e) {
        const link = e.target.closest('aside a[href]');
        if (link) {
            sessionStorage.setItem('catalog_scroll_pos', window.scrollY);
        }
    });

    (function() {
        const savedPos = sessionStorage.getItem('catalog_scroll_pos');
        if (savedPos !== null) {
            window.scrollTo(0, parseInt(savedPos));
            sessionStorage.removeItem('catalog_scroll_pos');
        }
    })();
</script>
