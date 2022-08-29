<script
    type="text/javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"
>
</script>
<script
    type="text/javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"
>
</script>
<script
    type="text/javascript"
    src="https://cdn.datatables.net/v/bs4-4.1.1/jszip-2.5.0/dt-1.10.24/b-1.7.0/b-html5-1.7.0/b-print-1.7.0/r-2.2.7/datatables.min.js"
>
</script>
<script
    type="text/javascript"
    src="{{ asset('js/loader.js') }}"
>
</script>
<script
    type="text/javascript"
>
    loader(true);
</script>

<script>

// sidebar open close js code
let navLinks = document.querySelector(".nav-links");
let menuOpenBtn = document.querySelector(".navbar .bx-menu");
let menuCloseBtn = document.querySelector(".nav-links .bx-x");
menuOpenBtn.onclick = function() {
navLinks.style.left = "0";
}
menuCloseBtn.onclick = function() {
navLinks.style.left = "-100%";
}


// sidebar submenu open close js code
let htmlcssArrow = document.querySelector(".htmlcss-arrow");
htmlcssArrow.onclick = function() {
 navLinks.classList.toggle("show1");
}
let jsArrow = document.querySelector(".js-arrow");
jsArrow.onclick = function() {
 navLinks.classList.toggle("show3");
}
let tickArrow = document.querySelector(".tickets-arrow");
tickArrow.onclick = function() {
 navLinks.classList.toggle("show4");
}
let curArrow = document.querySelector(".cur-arrow");
curArrow.onclick = function() {
 navLinks.classList.toggle("show5");
}
let userArrow = document.querySelector(".user-arrow");
userArrow.onclick = function() {
 navLinks.classList.toggle("show6");
}
let logsArrow = document.querySelector(".logs-arrow");
logsArrow.onclick = function() {
 navLinks.classList.toggle("show7");
}
</script>