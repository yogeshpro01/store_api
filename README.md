# store_api

This is a server-side web API created for the "Shopify Summer 2019 Developer Intern Challenge" by Yogesh Aggarwal. This is a REST API created using PHP. The server information can be updated in config.php. The table name for products can be updated in product.php. Each product must have an ID, name, price and inventory count. 

The API has the following functions - 

1. <b> Fetching all Products: </b> To call this function, the user must request for "http://localhost/[file_name]/api/main/read_all.php". The data is returned in the following format.
  
2. <b> Buying a Product </b>
  To call this function, the user must request for "http://localhost/[file_name]/api/main/buy_now.php". Along with this, the product name must be provided in the follwing format. 
  

3. <b> Buying multiple Products (Cart) </b>
  To call this function, the user must request for "http://localhost/[file_name]/api/main/cart.php". Along with this, the product name must be provided in the follwing format. 

4. <b> Calculating Price for a cart </b>
  To call this function, the user must request for "http://localhost/[file_name]/api/main/get_price.php". Along with this, the product name must be provided in the follwing format. 

5. Security Tokens
  JWT tokens have been implemented... 
