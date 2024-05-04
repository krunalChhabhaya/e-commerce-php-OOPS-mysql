<?php
session_start();

include 'header.php';
include 'dbinit.php';


?>
<div id="carouselExampleCaptions" class="carousel slide">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <!-- https://www.freepik.com/free-photo/close-up-clock-with-time-change_21798046.htm#fromView=search&page=1&position=30&uuid=73c35a50-d5ee-4e69-8cc0-ae2dbe89aef3?log-in=google -->
            <img src="./images/watch3.jpg" class="d-block w-100 carousel-image" alt="watch">
        </div>
        <div class="carousel-item">
            <!-- https://www.freepik.com/free-photo/businessman-checking-time_1131319.htm#fromView=search&page=2&position=2&uuid=630a9ef7-03c8-4a5e-9f15-a6e36a661b49 -->
            <img src="./images/watch4.jpg" class="d-block w-100 carousel-image" alt="watch">
        </div>
        <div class="carousel-item">
            <!-- https://www.freepik.com/free-photo/woman-using-smartwatch-with-digital-assistant_18771533.htm#fromView=search&page=4&position=15&uuid=630a9ef7-03c8-4a5e-9f15-a6e36a661b49 -->
            <img src="./images/watch5.jpg" class="d-block w-100 carousel-image" alt="watch">
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
<section class="gridSection bg-grey">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="gridContent py-5 px-3">
                    <h3 class="text-center text-black">Free Shipping WORLDWIDE</h3>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="gridContent py-5 px-3">
                    <h3 class="text-center text-black">Free In-store Returns</h3>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="gridContent py-5 px-3">
                    <h3 class="text-center text-black">Genuine Product Guarantee</h3>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="gridContent py-5 px-3">
                    <h3 class="text-center text-black">100% Secure Shopping</h3>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="categorySection py-5">
    <div class="container">
        <h2 class="text-black text-center mb-5">Watch Categories</h2>
        <div class="row g-4">
            <div class="col-lg-4 col-md-6 col-12">
                <div class="catMain">
                    <div class="catImage">
                        <img src="./images/casualwatch.jpg" class="w-100" alt="watch">
                    </div>
                    <div class="catContent bg-grey">
                        <h6 class="text-black text-center p-2">Casual Watch</h6>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <div class="catMain">
                    <div class="catImage">
                        <img src="./images/luxurywatch.jpg" class="w-100" alt="watch">
                    </div>
                    <div class="catContent bg-grey">
                        <h6 class="text-black text-center p-2">Luxury Watch</h6>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <div class="catMain">
                    <div class="catImage">
                        <img src="./images/sportwatch.jpg" class="w-100" alt="watch">
                    </div>
                    <div class="catContent bg-grey">
                        <h6 class="text-black text-center p-2">Sport Watch</h6>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <div class="catMain">
                    <div class="catImage">
                        <img src="./images/smartwatch.jpg" class="w-100" alt="watch">
                    </div>
                    <div class="catContent bg-grey">
                        <h6 class="text-black text-center p-2">Smart Watch</h6>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <div class="catMain">
                    <div class="catImage">
                        <img src="./images/dresswatch.jpg" class="w-100" alt="watch">
                    </div>
                    <div class="catContent bg-grey">
                        <h6 class="text-black text-center p-2">Dress Watch</h6>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <div class="catMain">
                    <div class="catImage">
                        <img src="./images/pilotwatch.jpg" class="w-100" alt="watch">
                    </div>
                    <div class="catContent bg-grey">
                        <h6 class="text-black text-center p-2">Pilot Watch</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<footer class="bg-grey py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-2 col-12">
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="javascript:void(0)" class="text-decoration-none text-black">Home</a></li>
                    <li class="mb-2"><a href="javascript:void(0)" class="text-decoration-none text-black">Products</a></li>
                    <li class="mb-2"><a href="javascript:void(0)" class="text-decoration-none text-black">Cart</a></li>
                    <li class="mb-2"><a href="javascript:void(0)" class="text-decoration-none text-black">Create Product</a></li>
                </ul>
            </div>
            <div class="col-md-5 col-12">
                <div class="d-flex">
                    <span class="text-black me-2">Address:</span>
                    <p class="text-grey">659, Ira niddles - G3RH6T, Kitchener, Ontario</p>
                </div>
                <div class="d-flex">
                    <span class="text-black me-2">Mobile:</span>
                    <a href="tel:+1 895-784-7854" class="text-decoration-none text-grey">+1 895-784-7854</a>
                </div>
            </div>
            <div class="col-md-5 col-12">
                <h4 class="text-black">Subscribe to Our Newsletter</h4>
                <div class="input-group mt-3">
                    <input type="text" class="form-control" placeholder="Enter your email address..."
                        aria-label="Recipient's username" aria-describedby="basic-addon2">
                    <a href="javascript:void(0)" class="input-group-text text-decoration-none" id="basic-addon2">Submit</a>
                </div>
            </div>
        </div>
    </div>
</footer>
<div class="p-3">
    <p class="text-grey text-center mb-0">&copy; All rights reserved by watchwise 2024.</p>
</div>