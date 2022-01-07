
                  
                  <link rel='stylesheet' href='../css/productPage.css'>
                      <main class='container'>
                      
                          <!-- Left Column / Headphones Image -->
                          <div class='left-column'>
                          <img data-image='Product' src='../productImg/moomin_midsummer_concept_full_res-cropped.jpg' style='float: left;' alt=''>
                          </div>
                      
                      
                          <!-- Right Column -->
                          <div class='right-column'>
                      
                          <!-- Product Description -->
                          <div class='product-description'>
                              <h1>Moomin art</h1>
                              <p>A nice art piece                </p>
                          </div>
                      
                          <!-- Product Configuration -->
                          <div class='product-configuration'>
                      
                          <!-- Product Pricing -->
                          <div class='product-price'>
                              <span>1000</span>
                              <form method = 'POST' action='Moomin art.php'>
                              <input class='cart-btn' name='cart-btn' id='cart-btn' type='submit' value='Add to cart'>
                              </form>
                          </div>
                          </div>
                      </main><?php include('../php/comment.php'); include('../php/cartfunction.php'); include('../php/rating.php'); include('../php/loginCheck.php'); ?>