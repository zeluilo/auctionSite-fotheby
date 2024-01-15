<?php

namespace Controllers;

require '../database.php';

class UserController
{
    private $categoryTable;
    private $auctionTable;
    private $auction_catTable;
    private $userTable;
    private $user_bid_categoryTable;
    private $auction_userTable;
    private $biddingTable;
    private $userAuctionTable;
    private $lot_auctionTable;
    private $lotTable;


    public function __construct($categoryTable, $auctionTable, $auction_catTable, $userTable, $auction_userTable, $user_bid_categoryTable, $biddingTable, $userAuctionTable, $lot_auctionTable, $lotTable)
    {
        $this->categoryTable = $categoryTable;
        $this->auctionTable = $auctionTable;
        $this->auction_catTable = $auction_catTable;
        $this->userTable = $userTable;
        $this->user_bid_categoryTable = $user_bid_categoryTable;
        $this->auction_userTable = $auction_userTable;
        $this->biddingTable = $biddingTable;
        $this->userAuctionTable = $userAuctionTable;
        $this->lot_auctionTable = $lot_auctionTable;
        $this->lotTable = $lotTable;
    }

    public function home()
    {
        $registrationSuccess = false;
        $loggedinSuccess = false;
        $loggedoutSuccess = false;

        // Check if registration success session variable is set
        if (isset($_SESSION['registrationSuccess']) && $_SESSION['registrationSuccess']) {
            // Unset the session variable to avoid displaying the modal on subsequent requests
            unset($_SESSION['registrationSuccess']);
            $registrationSuccess = true;
        }

        // Check if login success session variable is set
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']) {
            // Unset the session variable to avoid displaying the modal on subsequent requests
            unset($_SESSION['loggedin']);
            $loggedinSuccess = true;
        }

        // Check if logout success session variable is set
        if (isset($_SESSION['loggedout']) && $_SESSION['loggedout']) {
            // Unset the session variable to avoid displaying the modal on subsequent requests
            unset($_SESSION['loggedout']);
            $loggedoutSuccess = true;
        }

        $auctioncats = $this->lot_auctionTable->findAllDistinctAuctions();

        $auction_cat_bids = $this->user_bid_categoryTable->findAll();

        return [
            'template' => 'userhome.html.php',
            'variables' => [
                'auction_cat_bids' => $auction_cat_bids,
                'registrationSuccess' => $registrationSuccess,
                'loggedinSuccess' => $loggedinSuccess,
                'loggedoutSuccess' => $loggedoutSuccess,
                'auctioncats' => $auctioncats,
            ],
            'title' => 'Fotheby&apos;s Auction'
        ];
    }

    public function search(): array
    {
        $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
        $auction_cat_bids = $this->user_bid_categoryTable->findAll();
        $auctioncats = $this->auction_catTable->findAll();

        // Search for categories
        $categories = $this->categoryTable->findAll();

        // Search for auctions
        $auctionResults = $this->lot_auctionTable->searchAuctions($searchTerm);

        return [
            'template' => 'usersearch.html.php',
            'variables' => [
                'searchTerm' => $searchTerm,
                'categories' => $categories,
                'auctionResults' => $auctionResults,
                'auction_cat_bids' => $auction_cat_bids,
                'auctioncats' => $auctioncats,

            ],
            'title' => 'Admin Fotheby&apos;s',
        ];
    }

    public function filterCategory(): array
    {
        $catId = isset($_GET['catId']) ? intval($_GET['catId']) : 0;

        // Assuming you have a method to get auctions by category ID in your auction table
        $filteredAuctions = $this->auctionTable->getAuctionsByCategoryId($catId);
        $auctions = $this->lot_auctionTable->findAllDistinctAuctions();


        // Assuming you have a method to get all categories in your category table
        $categories = $this->categoryTable->findAll();

        return [
            'template' => 'filterCategory.html.php', // Replace with your template file
            'variables' => [
                'filteredAuctions' => $filteredAuctions,
                'categories' => $categories,
                'auctions' => $auctions
            ],
            'title' => 'Filtered Auctions',
        ];
    }

    public function catalogue(): array
    {

        $auction_cat_bids = $this->user_bid_categoryTable->findAll();
        $categories = $this->categoryTable->findAll();
        $auctioncats = $this->lot_auctionTable->findAllDistinctAuctions();

        $sortOrder = isset($_GET['sort']) ? $_GET['sort'] : 'asc'; // Default sorting order is ascending

        $auctions = $this->lot_auctionTable->findAllDistinctAuctions($sortOrder);


        return [
            'template' => 'usercatalogue.html.php',
            'variables' => [
                'auction_cat_bids' => $auction_cat_bids,
                'categories' => $categories,
                'auctions' => $auctions,
                'auctioncats' => $auctioncats,
                'sortOrder' => $sortOrder

            ],
            'title' => 'Admin Fotheby&apos;s'
        ];
    }

    public function userviewlots(): array
    {
        $aucId = $_GET['aucId']; // Assuming aucId is passed in the query string

        // Fetch the details of the selected auction
        $auctions = $this->auctionTable->find('aucId', $aucId)[0];
        $auctioncats = $this->lot_auctionTable->findAllDistinctAuctions();

        $sortOrder = isset($_GET['sort']) ? $_GET['sort'] : 'asc'; // Default sorting order is ascending

        // Fetch lots associated with the selected auction, sorted based on the selected criteria
        $lots = $this->lot_auctionTable->findAllSort($sortOrder, $aucId);


        return [
            'template' => 'userviewlots.html.php',
            'variables' => [
                'aucId' => $aucId,
                'lots' => $lots,
                'auctioncats' => $auctioncats,
                'auctions' => $auctions,
                'sortOrder' => $sortOrder
            ],
            'title' => 'Lots for Auction - ' . $auctions['title'] // Include auction title in the page title
        ];
    }



    public function bidpage(): array
    {

        $auction = $this->lotTable->find('lotId', $_GET['lotId'])[0];
        $auctions = $this->lot_auctionTable->find('lotId', $_GET['lotId'])[0];
        $bidders = $this->user_bid_categoryTable->getBiddersWithHighestBid($_GET['lotId']);

        // Get the highest bid amount
        $highestBid = $this->biddingTable->getHighestBidAmount($_GET['lotId']);
        $highestBid = $highestBid ? $highestBid : 0;

        return [
            'template' => 'userbidpage.html.php',
            'variables' => [
                'auction' => $auction,
                'auctions' => $auctions,
                'bidders' => $bidders,
                'highestBid' => $highestBid,
            ],
            'title' => 'Admin Users'
        ];
    }


    public function bid(): array
    {

        $this->checkLogin();

        $bidAmount = isset($_POST['bidamount']) ? floatval($_POST['bidamount']) : 0.0;
        $lotId = isset($_POST['lotId']) ? intval($_POST['lotId']) : 0;
        // Check if the user is logged in
        if (!isset($_SESSION['userDetails']['userId'])) {
            // Redirect to login page or show an error message
            header('location: /user/login');
            exit();
        }

        $userId = $_SESSION['userDetails']['userId'];

        // Get the highest bid amount for the auction
        $highestBid = $this->biddingTable->getHighestBidAmount($lotId);

        // Check if bid amount is greater than the highest bid
        if ($bidAmount > $highestBid) {
            // Insert the bid into the database
            $values = [
                'bidamount' => $bidAmount,
                'lotId' => $lotId,
                'userId' => $userId,
                'datecreate' => date('Y-m-d H:i'),
                'status' => 'Ongoing'
            ];
            $this->biddingTable->insert($values);
            header('location: /user/thankyou');
            exit; // Add exit to stop further execution
        } else {
            $message = 'Bid amount should be higher than the current highest bid!';
        }

        return [
            'template' => 'userbidpage.html.php',
            'variables' => [
                'message' => $message
            ],
            'title' => 'Bidding'
        ];
    }

    public function addauction(): array
    {
        $this->checkLogin();

        $auction = $this->auctionTable->findAll();
        $category = $this->categoryTable->findAll();
        $message = ''; // Initialize an empty message

        $for_directory = "img/auctions/";

        if (isset($_FILES["auct_pic"])) {  // Check if the key exists
            $for_directory = "img/auctions/";
            $for_pic = $for_directory . basename($_FILES["auct_pic"]["name"]);
            $picType = strtolower(pathinfo($for_pic, PATHINFO_EXTENSION));

            // Check if the form is submitted
            if (isset($_POST['submit'])) {
                // Validate the image file
                $validate = getimagesize($_FILES["auct_pic"]["tmp_name"]);

                if ($validate === false) {
                    $message = 'Invalid image file format. Please choose a valid image.';
                } else {
                    // Attempt to move the uploaded file
                    $browse = move_uploaded_file($_FILES["auct_pic"]["tmp_name"], $for_pic);

                    if (!$browse) {
                        $message = 'Failed to upload image. Please try again.';
                    } else {
                        // Insert data into the database
                        $values = [
                            'title' => $_POST['title'],
                            'description' => $_POST['description'],
                            'endDate' => $_POST['endDate'],
                            'catId' => $_POST['catId'],
                            'img' => $_FILES["auct_pic"]["name"],
                            'datecreate' => date('Y-m-d H:i'),
                            'status' => 'Upcoming',
                            'userId' => $_SESSION['userDetails']["userId"]
                        ];

                        $inserted = $this->auctionTable->insert($values);

                        if ($inserted) {
                            $message = 'Failed to add auction. Please try again.';
                        } else {
                            header('location: /user/auctionThankyou');
                        }
                    }
                }
            }
        }

        return [
            'template' => 'useraddauction.html.php',
            'variables' => [
                'auction' => $auction,
                'category' => $category,
                'message' => $message
            ],
            'title' => 'Add Auction',
        ];
    }

    public function edituser(): array
    {
        $userId = isset($_GET['userId']) ? $_GET['userId'] : null;

        if (isset($_POST['submit'])) {
            $values = [
                'userId' => $_POST['userId'],  // Use the value from the URL, not from $_POST
                'firstname' => $_POST['firstname'],
                'lastname' => $_POST['lastname'],
                'email' => $_POST['email'],
                'number' => $_POST['number'],
                'address' => $_POST['address'],
                'checkAdmin' => $_SESSION['userDetails']["checkAdmin"]
            ];

            $_SESSION['userDetails'] = [
                'userId' => $_POST['userId'],  // Use the value from the URL, not from $_POST
                'firstname' => $_POST['firstname'],
                'lastname' => $_POST['lastname'],
                'email' => $_POST['email'],
                'number' => $_POST['number'],
                'address' => $_POST['address'],
                'checkAdmin' => $_SESSION['userDetails']["checkAdmin"]
            ];

            $this->userTable->update($values);
            header('location: /user/home');
            exit();
        }

        $user = $this->userTable->find('userId', $userId)[0];

        return [
            'template' => 'usereditprofile.html.php',
            'variables' => [
                'user' => $user
            ],
            'title' => 'Edit Account'
        ];
    }



    public function thankyou(): array
    {
        $this->checkLogin();

        return [
            'template' => 'userthankyou.html.php',
            'variables' => [],
            'title' => 'Thank you for Bidding...'
        ];
    }

    public function contact(): array
    {

        return [
            'template' => 'usercontact.html.php',
            'variables' => [],
            'title' => 'Contact Us...'
        ];
    }
    public function auctionThankyou(): array
    {
        $this->checkLogin();

        return [
            'template' => 'auctionthankyou.html.php',
            'variables' => [],
            'title' => 'Thank you for Adding Auction...'
        ];
    }

    public function register(): array
    {
        $error = '';

        if (isset($_POST['submit'])) {
            $email = $_POST['email'];

            $existingEmail = $this->userTable->find('email', $email);
            if (!empty($existingEmail)) {
                $error = 'Account exists already';
                return [
                    'template' => 'register.html.php',
                    'variables' => ['error' => $error],
                    'title' => 'Create Account'
                ];
            }

            $password = $_POST['password'];
            $repeatPassword = $_POST['repeat_password'];

            // Validate password
            if (strlen($password) < 8 || !preg_match('/\d/', $password)) {
                $error = 'Password must be at least 8 characters long and contain at least one number';
                return [
                    'template' => 'register.html.php',
                    'variables' => ['error' => $error],
                    'title' => 'Create Account',
                ];
            }

            // Check if passwords match
            if ($password !== $repeatPassword) {
                $error = 'Passwords don\'t match';
                return [
                    'template' => 'register.html.php',
                    'variables' => ['error' => $error],
                    'title' => 'Create Account',
                ];
            }

            $pw = password_hash($password, PASSWORD_DEFAULT);

            $values = [
                'firstname' => $_POST['firstname'],
                'lastname' => $_POST['lastname'],
                'email' => $_POST['email'],
                'password' => $pw,
                'number' => $_POST['number'],
                'address' => $_POST['address'],
                'checkAdmin' => 'USER',
                'datecreate' => date('Y-m-d H:i'),
            ];

            $_SESSION['registrationSuccess'] = true;


            $this->userTable->insert($values);
            header("Location: /admin/login");
            exit();
        }

        return [
            'template' => 'register.html.php',
            'variables' => ['error' => $error],
            'title' => 'Create Account',
        ];
    }


    public function startSession()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
    }

    public function checkLogin()
    {
        $this->startSession(); // Ensure session is started

        if (!isset($_SESSION['userDetails']['checkAdmin'])) {
            $this->redirectToLogin();
        }
    }


    public function logout()
    {
        $this->startSession(); // Ensure session is started

        session_unset();
        session_destroy();

        // Set a session variable for successful logout
        $_SESSION['loggedout'] = true;

        $this->redirectToLogin();
    }

    private function redirectToLogin()
    {
        header("Location: /admin/login");
        exit();
    }

    // Add more functions as needed for user-related actions

    // For example:
    // public function profile() {
    //     // Implement profile functionality for the user here
    // }

    // public function settings() {
    //     // Implement settings functionality for the user here
    // }
}
