

             <div class="row">

                <h1 class="page-header">
                All Products

                </h1>

                <h3 class="bg-success"><?php display_message(); ?></h3>
                <table class="table table-hover">


                     <thead>

                        <tr>
                            <th>Product Id</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Image</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php get_admin_products(); ?>
                    


                    </tbody>
                </table>
          


             </div>

