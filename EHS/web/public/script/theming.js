document.getElementById('themebutton').onclick = function () {
    document.getElementById('theme_css').href = '{{ asset('public/CSS/style2.css') }}';
};
