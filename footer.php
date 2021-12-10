
<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-4 social " style="text-align:center">
                <hr class="light">
                <h5 class="brandname" style="text-align:center">ROCQUE</h5>
                <hr class="light">
                <p>Social Media</p>
                <a href="https://www.facebook.com/"><i class="fab fa-facebook"></i></a>
                <a href="https://www.instagram.com/"><i class="fab fa-instagram"></i></a>
            </div>
            <div class="col-md-4 " style="text-align:center">
                <hr class="light">
                <h5 style="text-align:center">Find Us</h5>
                <hr class="light">
                <p>1640 Riverside Dr</p>
                <p>Seattle, WA 98109</p>
                <p>(206) 843-9782</p>
            </div>
            <div class="col-md-4 " style="text-align:center">
                <hr class="light">
                <h5 style="text-align:center">Customer Service Hours</h5>
                <hr class="light">
                <p>Monday - Thursday: 9:00 a.m. - 5:00 p.m.</p>
                <p>Friday and Saturday: 10:00 a.m. - 6:00 p.m.</p>
                <p>Sunday: Closed</p>
            </div>
        </div>
        <div class='row attribution'>
            <p>Favicon made by <a href="https://www.freepik.com" title="Freepik">Freepik</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a></p>
        </div>
    </div>
</footer>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script>
    //active links based on current url and the href of the nav-link elements
    var navLinks = document.getElementsByClassName('nav-link');
    const path = window.location.href.split('?')[0];

    for (let link of navLinks) {
        let href = link.getAttribute('href');
        if (href == path) {
            link.classList.add('active');
        } else {
            link.classList.remove('active');
        }
    }
</script>
<?php if(!isset($_SESSION['userId'])){ echo "<script src='$path/scripts/login_signup_modal.js'></script> ";}?>

</body>
</html>
