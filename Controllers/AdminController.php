<?php
// Outside the class

namespace Controllers;
use Models\categoryTable;
session_start();

class AdminController
{
    private $categoryTable;
    private $auctionTable;
    private $auction_catTable;
    private $biddingTable;
    private $userTable;
    private $auction_userTable;
    private $user_bid_categoryTable;
    private $reviewAuctionTable;
    private $lotTable;
    private $lot_userTable;
    private $lot_auctionTable;

    public function __construct($categoryTable, $auctionTable, $auction_catTable, $userTable, $biddingTable, $auction_userTable, $user_bid_categoryTable, $reviewAuctionTable, $lotTable, $lot_userTable, $lot_auctionTable)
    {
        $this->categoryTable = $categoryTable;
        $this->auctionTable = $auctionTable;
        $this->auction_catTable = $auction_catTable;
        $this->userTable = $userTable;
        $this->biddingTable = $biddingTable;
        $this->auction_userTable = $auction_userTable;
        $this->user_bid_categoryTable = $user_bid_categoryTable;
        $this->reviewAuctionTable = $reviewAuctionTable;
        $this->lotTable = $lotTable;
        $this->lot_userTable = $lot_userTable;
        $this->lot_auctionTable = $lot_auctionTable;

;
    }
    public function home(): array
{
    $this->checkLogin();

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

    // Fetch all bids
    $allBids = $this->user_bid_categoryTable->findAll();
    $reviewAuctions = $this->lot_userTable->findAll();
    $users = $this->userTable->findAll();

    // Group bids by bidder
    $bidsGroupedByBidder = [];
    foreach ($allBids as $bid) {
        $bidderKey = $bid['firstname'] . ' ' . $bid['lastname'];
        if (!isset($bidsGroupedByBidder[$bidderKey])) {
            $bidsGroupedByBidder[$bidderKey] = [];
        }
        $bidsGroupedByBidder[$bidderKey][] = $bid;
    }

    return [
        'template' => 'home.html.php',
        'variables' => [
            'bidsGroupedByBidder' => $bidsGroupedByBidder,
            'reviewAuctions' => $reviewAuctions,
            'users' => $users,
            'registrationSuccess' => $registrationSuccess,
            'loggedinSuccess' => $loggedinSuccess,
            'loggedoutSuccess' => $loggedoutSuccess,
        ],
        'title' => 'Admin Fotheby&apos;s'
    ];
}

    
    
    


    /*************************************************
    * Category Section
    ************************************************/

    public function addcat(): array
    {
        $category = $this->categoryTable->findAll();
        $message = ''; // Initialize an empty message
    
        if (isset($_POST['submit'])) {
            $values = [
                'catname' => $_POST['catname'],
                'datecreate' => date('Y-m-d H:i')
            ];
            $inserted = $this->categoryTable->insert($values);
    
            if ($inserted) {
                $message = 'Failed to add category. Please try again.';
            } else {
                $message = 'Category added successfully!';
            }
        }
    
        return [
            'template' => 'addcat.html.php',
            'variables' => [
                'category' => $category,
                'message' => $message,
            ],
            'title' => 'Add Category',
        ];
    }
    


    public function editcategory(): array
{
    $this->checkLogin();
    $catId = isset($_GET['catId']) ? $_GET['catId'] : null;
    $category = $this->categoryTable->find('catId', $catId)[0];
    
    // Fetch auctions for the current category
    $auctions = $this->auction_catTable->find('category_catId', $catId);
    
    $message = '';

    if (isset($_POST['submit'])) {
        $values = [
            'catId' => $_POST['catId'],
            'catname' => $_POST['catname'],
            'dateupdate' => date('Y-m-d H:i')
        ];

        $inserted = $this->categoryTable->update($values);

        if ($inserted) {
            $message = 'Failed to add category. Please try again.';
        } else {
            $message = 'Category updated successfully!';
        }

        header('location: /admin/managecat');
    }

    return [
        'template' => 'editcat.html.php',
        'variables' => [
            'category' => $category,
            'auctions' => $auctions,
            'message' => $message
        ],
        'title' => 'Edit category'
    ];
}


    public function managecat(): array
    {
        $this->checkLogin();
        $categories = $this->categoryTable->findAll();

        return [
            'template' => 'managecat.html.php',
            'variables' => [
                'categories' => $categories
            ],
            'title' => 'List Of Categories'
        ];
    }   
    
    
    public function deletecategory(): array
    {
        $this->checkLogin();
        if (isset($_GET['catId'])) {
            $id = $_GET['catId'];
            $this->categoryTable->delete($id);
            header('location: /admin/managecat');
        }
        return [
            'template' => 'managecat.html.php',
            'variables' => ['categories' => $this->categoryTable->findAll()],
            'title' => 'List Of Categories'
        ];
    }

    public function deletelot(): array
    {
        $this->checkLogin();
        if (isset($_GET['lotId'])) {
            $id = $_GET['lotId'];
            $this->lotTable->delete($id);
            header('location: /admin/managelot');
        }
        return [
            'template' => 'managelot.html.php',
            'variables' => ['lots' => $this->lotTable->findAll()],
            'title' => 'List Of Lots'
        ];
    }

    /*************************************************
    * End of Category Section
    ************************************************/

    /*************************************************
    * Auction Section
    ************************************************/
    public function addauction(): array
    {
        $auction = $this->auctionTable->findAll();
        $category = $this->categoryTable->findAll();
        $message = ''; // Initialize an empty message

        $for_directory = "img/auctions/";
    
        if (isset($_FILES["auct_pic"])) {  // Check if the key exists
            $for_pic = $for_directory . basename($_FILES["auct_pic"]["name"]);
            $browse = 1;
            $picType = strtolower(pathinfo($for_pic, PATHINFO_EXTENSION));
        
            if (isset($_POST['submit'])) {
                $values = [
                    'title' => $_POST['title'],
                    'description' => $_POST['description'],
                    'endDate' => $_POST['endDate'],
                    'catId' => $_POST['catId'],
                    'startDate' => $_POST['startDate'],
                    'img' => isset($_FILES["auct_pic"]["name"]) ? $_FILES["auct_pic"]["name"] : '',
                    'datecreate' => date('Y-m-d H:i'),
                    'status' => 'Upcoming',
                    'userId' => $_SESSION['userDetails']["userId"]
                ];

                $inserted = $this->auctionTable->insert($values);
        
                if ($inserted) {
                    $message = 'Failed to add auction. Please try again.';
                } else {
                    $message = 'Auction added successfully!';
                }

                if ($_FILES["auct_pic"]["name"] !== "") {
                    $validate = getimagesize($_FILES["auct_pic"]["tmp_name"]);
                    if ($validate != false) {
                        $browse = 1;
                    } else {
                        $browse = 0;
                        $message = 'Invalid image file format. Please choose a valid image.';
                    }
                    if ($browse) {
                        move_uploaded_file($_FILES["auct_pic"]["tmp_name"], $for_pic);
                    }
                }

                header('location: /admin/manageauction');
            }
        }
    
        return [
            'template' => 'addauction.html.php',
            'variables' => [
                'auction' => $auction,
                'category' => $category,
                'message' => $message
            ],
            'title' => 'Add Auction',
        ];
    }
    


    public function editauction(): array
{
    $aucId = isset($_GET['aucId']) ? $_GET['aucId'] : null;

    $lots = $this->lot_userTable->find('auctionId', $aucId);

    // Check if the form is submitted
    if (isset($_POST['submit'])) {
        $auction = $this->auctionTable->find('aucId', $_POST['aucId'])[0];
        $categories = $this->categoryTable->findAll();
        $for_directory = "img/auctions/";

        $existingImage = $auction['img']; // Store the existing image name

        if (isset($_FILES["auct_pic"])) {  // Check if the key exists
            $for_pic = $for_directory . basename($_FILES["auct_pic"]["name"]);
            $browse = 1;
            $picType = strtolower(pathinfo($for_pic, PATHINFO_EXTENSION));

            // Check if a new image is provided in the form
            if ($_FILES["auct_pic"]["name"] !== "") {
                $values = [
                    'aucId' => $_POST['aucId'],
                    'title' => $_POST['title'],
                    'description' => $_POST['description'],
                    'endDate' => $_POST['endDate'],
                    'startDate' => $_POST['startDate'],
                    'catId' => $_POST['catId'],
                    'img' => $_FILES["auct_pic"]["name"],
                    'dateupdate' => date('Y-m-d H:i'),
                    'status' => 'Upcoming',
                    'userId' => $_SESSION['userDetails']["userId"]
                ];

                $this->auctionTable->update($values);

                // Move the new image only if it's provided
                $validate = getimagesize($_FILES["auct_pic"]["tmp_name"]);
                if ($validate != false) {
                    $browse = 1;
                    move_uploaded_file($_FILES["auct_pic"]["tmp_name"], $for_pic);
                } else {
                    $browse = 0;
                    $message = 'Invalid image file format. Please choose a valid image.';
                }
            } else {
                // If no new image is provided, retain the existing image
                $values = [
                    'aucId' => $_POST['aucId'],
                    'title' => $_POST['title'],
                    'startDate' => $_POST['startDate'],
                    'description' => $_POST['description'],
                    'endDate' => $_POST['endDate'],
                    'catId' => $_POST['catId'],
                    'img' => $existingImage, // Retain the existing image
                    'dateupdate' => date('Y-m-d H:i'),
                    'status' => 'Upcoming'
                ];

                $this->auctionTable->update($values);
            }

            // Redirect after processing the form
            header('location: /admin/manageauction');
            exit; // Terminate script execution after redirection
        }
    }

    // If form is not submitted or after redirection, display the editauction template
    $auction = $this->auctionTable->find('aucId', $aucId)[0];
    $categories = $this->categoryTable->findAll();

    return [
        'template' => 'editauction.html.php',
        'variables' => ['auction' => $auction, 'lots' => $lots, 'categories' => $categories],
        'title' => 'Edit Auction'
    ];
}

    public function manageauction(): array
    {
        $this->checkLogin();
        $auctions = $this->auction_catTable->findAll();

        return [
            'template' => 'manageauction.html.php',
            'variables' => [
                'auctions' => $auctions
            ],
            'title' => 'List Of Auctions'
        ];
    }

    public function deleteauction(): array
    {
        $this->checkLogin();
        if (isset($_GET['aucId'])) {
            $id = $_GET['aucId'];
            $this->auctionTable->delete($id);
            header('location: /admin/manageauction');
        }
        return [
            'template' => 'manageauction.html.php',
            'variables' => ['auctions' => $this->auctionTable->findAll()],
            'title' => 'List Of Auctions'
        ];
    }

    public function viewauction(): array
    {
        $this->checkLogin();
        $catalogues = $this->auction_catTable->findAll();

        return [
            'template' => 'viewauction.html.php',
            'variables' => [
                'catalogues' => $catalogues
            ],
            'title' => 'Admin Fotheby&apos;s'
        ];
    }

    /*************************************************
    * Lot Section
    ************************************************/
    public function addlot(): array
{
    $lot = $this->lotTable->findAll();
    $auction = $this->auctionTable->findAll();
    $message = ''; // Initialize an empty message

    $for_directory = "img/lots/";

    // Get the maximum lot number
    $maxLotNum = $this->lotTable->getMaxLotNum();
    
    // Calculate the next lot number
    $newLotNum = $maxLotNum + 1;

    if (isset($_FILES["auct_pic"])) {  // Check if the key exists
        $for_pic = $for_directory . basename($_FILES["auct_pic"]["name"]);
        $browse = 1;
        $picType = strtolower(pathinfo($for_pic, PATHINFO_EXTENSION));
    
        if (isset($_POST['submit'])) {
            $values = [
                'lotnum' => $newLotNum,
                'lotname' => $_POST['lotname'],
                'lotdesc' => $_POST['lotdesc'],
                'year' => $_POST['year'],
                'price' => $_POST['price'],
                'auctionId' => !empty($_POST['auctionId']) ? $_POST['auctionId'] : null,
                'img' => isset($_FILES["auct_pic"]["name"]) ? $_FILES["auct_pic"]["name"] : '',
                'datecreate' => date('Y-m-d H:i'),
                'userId' => $_SESSION['userDetails']["userId"]
            ];

            $inserted = $this->lotTable->insert($values);
    
            if ($inserted) {
                $message = 'Failed to add lot. Please try again.';
            } else {
                $message = 'Auction added successfully!';
            }

            if ($_FILES["auct_pic"]["name"] !== "") {
                $validate = getimagesize($_FILES["auct_pic"]["tmp_name"]);
                if ($validate != false) {
                    $browse = 1;
                } else {
                    $browse = 0;
                    $message = 'Invalid image file format. Please choose a valid image.';
                }
                if ($browse) {
                    move_uploaded_file($_FILES["auct_pic"]["tmp_name"], $for_pic);
                }
            }

            header('location: /admin/managelot');
        }
    }

    return [
        'template' => 'addlot.html.php',
        'variables' => [
            'lot' => $lot,
            'auction' => $auction,
            'message' => $message,
            'newLotNum' => $newLotNum,
            'maxLotNum' => $maxLotNum
        ],
        'title' => 'Create a Lot',
    ];
}

public function editlot(): array
{
    // Check if the form is submitted
    if (isset($_POST['submit'])) {
        $lot = $this->lotTable->find('lotId', $_POST['lotId'])[0];
        $lots = $this->lot_userTable->find('lotId', $_POST['lotId'])[0];
        $auctions = $this->auctionTable->findAll();
        $for_directory = "img/lots/";

        $existingImage = $lot['img']; // Store the existing image name

        if (isset($_FILES["auct_pic"])) {  // Check if the key exists
            $for_pic = $for_directory . basename($_FILES["auct_pic"]["name"]);
            $browse = 1;
            $picType = strtolower(pathinfo($for_pic, PATHINFO_EXTENSION));

            // Check if a new image is provided in the form
            if ($_FILES["auct_pic"]["name"] !== "") {
                $values = [
                    'lotId' => $_POST['lotId'],
                    'lotname' => $_POST['lotname'],
                    'lotdesc' => $_POST['lotdesc'],
                    'lotnum' => $_POST['lotnum'],
                    'auctionId' => !empty($_POST['auctionId']) ? $_POST['auctionId'] : null,
                    'price' => $_POST['price'],
                    'year' => $_POST['year'],
                    'img' => $_FILES["auct_pic"]["name"],
                    'dateupdate' => date('Y-m-d H:i')
                ];

                $this->lotTable->update($values);

                // Move the new image only if it's provided
                $validate = getimagesize($_FILES["auct_pic"]["tmp_name"]);
                if ($validate != false) {
                    $browse = 1;
                    move_uploaded_file($_FILES["auct_pic"]["tmp_name"], $for_pic);
                } else {
                    $browse = 0;
                    $message = 'Invalid image file format. Please choose a valid image.';
                }
            } else {
                // If no new image is provided, retain the existing image
                $values = [
                    'lotId' => $_POST['lotId'],
                    'lotname' => $_POST['lotname'],
                    'lotdesc' => $_POST['lotdesc'],
                    'auctionId' => !empty($_POST['auctionId']) ? $_POST['auctionId'] : null,
                    'price' => $_POST['price'],
                    'year' => $_POST['year'],
                    'img' => $existingImage,
                    'dateupdate' => date('Y-m-d H:i')
                ];

                $this->lotTable->update($values);
            }

            // Redirect after processing the form
            header('location: /admin/managelot');
            exit; // Terminate script execution after redirection
        }
    }

    // If form is not submitted or after redirection, display the editauction template
    $lot = $this->lotTable->find('lotId', $_GET['lotId'])[0];
    $lots = $this->lot_userTable->find('lotId', $_GET['lotId'])[0];
    $auctions = $this->auctionTable->findAll();

    return [
        'template' => 'editlot.html.php',
        'variables' => ['auctions' => $auctions, 'lot' => $lot, 'lots' => $lots],
        'title' => 'Edit Lot'
    ];
}

public function managelot(): array
{
    $this->checkLogin();
    $lots = $this->lotTable->findAll();

    // Fetch auction titles for all lots
    $auctionTitles = [];
    foreach ($lots as $lot) {
        if (!empty($lot['auctionId'])) {
            $auction = $this->auctionTable->find('aucId', $lot['auctionId']);
            
            // Check if the result is not empty and if 'title' is set in the first row
            if (!empty($auction) && isset($auction[0]['title'])) {
                $auctionTitles[$lot['auctionId']] = $auction[0]['title'];
            } else {
                $auctionTitles[$lot['auctionId']] = '-';
            }
        }
    }

    return [
        'template' => 'managelot.html.php',
        'variables' => [
            'lots' => $lots,
            'auctionTitles' => $auctionTitles,
        ],
        'title' => 'List Of Lots'
    ];
}





    /*************************************************
    * Catalgoue Section
    ************************************************/

    public function catalogue(): array
    {
        $catalogues = $this->auction_catTable->findAll();

        return [
            'template' => 'catalogue.html.php',
            'variables' => [
                'catalogues' => $catalogues
            ],
            'title' => 'Admin Fotheby&apos;s'
        ];

    }

    /*************************************************
    * Users & Buyers Section
    ************************************************/

    public function viewusers(): array
    {
        $users = $this->userTable->findAll();

        return [
            'template' => 'viewusers.html.php',
            'variables' => [
                'users' => $users
            ],
            'title' => 'Admin Users'
        ];

    }

    public function viewsellers(): array
    {
        $users = $this->userTable->findAll();

        return [
            'template' => 'viewsellers.html.php',
            'variables' => [
                'users' => $users
            ],
            'title' => 'Admin Users'
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
            header('location: /admin/home');
            exit();
        }

        $user = $this->userTable->find('userId', $userId)[0];

        return [
            'template' => 'edituser.html.php',
            'variables' => [
                'user' => $user
            ],
            'title' => 'Edit Account'
        ];
    }

    public function viewbidders(): array
    {
        $bidders = $this->user_bid_categoryTable->findAll();

        return [
            'template' => 'viewbidders.html.php',
            'variables' => [
                'bidders' => $bidders
            ],
            'title' => 'Admin Users'
        ];

    }

    /*************************************************
    * Bidding Section
    ************************************************/
    public function bidpage(): array
    {
        $auction = $this->auctionTable->find('aucId', $_GET['aucId'])[0];
        $auctions = $this->auction_catTable->find('aucId', $_GET['aucId'])[0];
        $auction_users = $this->auction_userTable->find('aucId', $_GET['aucId'])[0];

        return [
            'template' => 'bid.html.php',
            'variables' => ['auction' => $auction, 'auctions' => $auctions, 'auction_users' => $auction_users],

            'title' => 'Admin Users'
        ];

    }

    
    public function bid(): array
    {

        $values = [
            'bidamount' => $_POST['bidamount'],
            'auctionId' => $_POST ['auctionId'],
            'userId' => $_SESSION['userDetails']["userId"]
            ];
            $this->biddingTable->insert($values);
            header('location: /admin/catalogue');
        return [
            'template' => 'bid.html.php',
            'variables' => [],
            'title' => 'Admin Users'
        ];

    }
    

    public function search(): array
    {
        $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
        
        // Search for auctions
        $auctionResults = $this->lot_auctionTable->searchAuction($searchTerm);

        $lotResults = $this->lot_auctionTable->searchLot($searchTerm);

        // Fetch auction titles for all lots
    $auctionTitles = [];
    foreach ($lotResults as $lot) {
        if (!empty($lot['aucId'])) {
            $auction = $this->auctionTable->find('aucId', $lot['aucId']);
            
            // Check if the result is not empty and if 'title' is set in the first row
            if (!empty($auction) && isset($auction[0]['title'])) {
                $auctionTitles[$lot['aucId']] = $auction[0]['title'];
            } else {
                $auctionTitles[$lot['aucId']] = '-';
            }
        }
    }

    
        return [
            'template' => 'search.html.php',
            'variables' => [
                'searchTerm' => $searchTerm,
                'auctionResults' => $auctionResults,
                'lotResults' => $lotResults,
                'auctionTitles' => $auctionTitles,

            ],
            'title' => 'Admin Fotheby&apos;s'
        ];
    }
    
    public function register(): array
    {
        $error = '';

        if (isset($_POST['submit'])) {
            $email = $_POST['email'];

            // Check if email already exists
            $existingEmail = $this->userTable->find('email', $email);
            if (!empty($existingEmail) || !empty($existingcheckAdmin)) {
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
                'checkAdmin' => 'ADMIN',
                'datecreate' => date('Y-m-d H:i'),
            ];

            $this->userTable->insert($values);
            header('location: /user/home');

            // Set a session variable for successful registration
            $_SESSION['registrationSuccess'] = true;

            $userId = $this->userTable->insert($values);

            // Store user details in a session variable
            $_SESSION['userDetails'] = [
                'firstname' => $_POST['firstname'],
                'lastname' => $_POST['lastname'],
                'email' => $_POST['email'],
                'number' => $_POST['number'],
                'address' => $_POST['address'],
                'checkAdmin' => 'ADMIN',
                'datecreate' => date('Y-m-d H:i'),
            ];

            // Redirect to the home page
            header('location: /admin/home');
            exit(); // Add this line to prevent further code execution after redirection
        }

        return [
            'template' => 'register.html.php',
            'variables' => ['error' => $error],
            'title' => 'Create Account',
        ];
    }


    public function login(): array
    {
        if (isset($_POST['submit'])) {
            $user = $this->userTable->findByEmail($_POST['email']);
            if ($user) {
                $verify_pw = password_verify($_POST['password'], $user['password']);
                if ($verify_pw) {
                    // Regenerate session ID for security
                    session_regenerate_id(true);

                    $_SESSION['loggedin'] = $user['userId'];
                    $_SESSION['userDetails'] = $user;

                    $_SESSION['loggedinSuccess'] = true;

                    // Check if the user role is "USER"
                    if ($user['checkAdmin'] === 'USER' || $user['checkAdmin'] === 'SELLER') {
                        // Redirect to the user home page after successful login
                        header("Location: /user/home");
                        exit();
                    } else {
                        // Redirect to the admin home page after successful login
                        header("Location: /admin/home");
                        exit();
                    }
                } else {
                    $error = 'Invalid email or password';
                }
            } else {
                $error = 'Invalid email or password';
            }
        }

        return [
            'template' => 'login.html.php',
            'variables' => ['error' => $error ?? ''],
            'title' => 'Login',
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


}


