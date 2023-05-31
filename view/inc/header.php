<!-- <div id="header">
</div> -->
   <!-- Topbar Start -->
   <div class="container-fluid bg-dark py-3 px-lg-5 d-none d-lg-block">
        <div class="row">
            <div class="col-md-6 text-center text-lg-left mb-2 mb-lg-0">
                <div class="d-inline-flex align-items-center">
                    <a class="text-body pr-3" href=""><i class="fa fa-phone-alt mr-2"></i>+012 345 6789</a>
                    <span class="text-body">|</span>
                    <a class="text-body px-3" href=""><i class="fa fa-envelope mr-2"></i>info@example.com</a>
                </div>
            </div>
            <div class="col-md-6 text-center text-lg-right">
                <div class="d-inline-flex align-items-center">
                    <a class="text-body px-3" href="">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a class="text-body px-3" href="">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a class="text-body px-3" href="">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a class="text-body px-3" href="">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a class="text-body pl-3" href="">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Topbar End -->


    <!-- Navbar Start -->
    <div class="container-fluid position-relative nav-bar p-0">
        <div class="position-relative px-lg-5" style="z-index: 9;">
            <nav class="navbar navbar-expand-lg bg-secondary navbar-dark py-3 py-lg-0 pl-3 pl-lg-5">
                <a href="" class="navbar-brand">
                    <h1 class="text-uppercase text-primary mb-1">Carxofera</h1>
                </a>
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-between px-3" id="navbarCollapse">
                    <div class="navbar-nav ml-auto py-0 ">
                        <div class="cart nav-item nav-link"></div>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <!-- Navbar End -->
    
    <!-- Search Start -->
    <div class="container-fluid bg-white pt-3 px-lg-5 d-flex justify-content-center">
        <div class="row mx-n2" <?php echo $style;?>>
            <div class="col-xl-3 col-lg-4 col-md-6 px-2">
                <select class="custom-select px-4 mb-3" style="height: 50px;" id="select_brand"></select>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 px-2">
                <select class="custom-select px-4 mb-3" style="height: 50px;" id="select_model"></select>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 px-2">
                <input class="form-control" type="text" id="autocom" autocomplete="off" style="height: 50px;" />
                <div id="search_auto"></div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 px-2">
                <button class="btn btn-primary btn-block mb-3" type="submit" style="height: 50px;" id="search-btn">Search</button>
            </div>
        </div>
    </div>
    <!-- Search End -->

    