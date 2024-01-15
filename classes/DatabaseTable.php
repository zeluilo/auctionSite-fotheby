<?php
class DatabaseTable
{
    private $pdo;
    private $table;
    private $primaryKey;

    public function __construct($pdo, $table, $primaryKey)
    {
        $this->pdo = $pdo;
        $this->table = $table;
        $this->primaryKey = $primaryKey;
    }

    public function find($field, $value)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM ' . $this->table . ' WHERE ' . $field . ' = :value');

        $criteria = [
            'value' => $value
        ];
        $stmt->execute($criteria);

        return $stmt->fetchAll();
    }


    public function findAll()
    {
        $stmt = $this->pdo->prepare('SELECT * FROM ' . $this->table);

        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function insert($record)
    {
        $keys = array_keys($record);

        $values = implode(', ', $keys);
        $valuesWithColon = implode(', :', $keys);

        $query = 'INSERT INTO ' . $this->table . ' (' . $values . ') VALUES (:' . $valuesWithColon . ')';

        $stmt = $this->pdo->prepare($query);

        $stmt->execute($record);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare('DELETE FROM ' . $this->table . ' WHERE ' . $this->primaryKey . ' = :id');
        $criteria = [
            'id' => $id
        ];
        $stmt->execute($criteria);
    }

    public function getHighestBidAmount($lotId): float
    {
        $sql = "SELECT MAX(bidamount) as highestBid FROM bidding WHERE lotId = :lotId";
        $query = $this->pdo->prepare($sql);
        $query->bindParam(':lotId', $lotId, PDO::PARAM_INT);

        if ($query->execute()) {
            $result = $query->fetch(PDO::FETCH_OBJ);

            return $result ? (float)$result->highestBid : 0.0;
        } else {
            // Handle the error or return an appropriate value
            return 0.0;
        }
    }

    public function getBiddersWithHighestBid($lotId)
    {
        $sql = "SELECT ubc.*, u.firstname, u.lastname, MAX(b.bidamount) AS highestBid
                FROM user_bid_category ubc
                JOIN users u ON ubc.UserId = u.userId
                LEFT JOIN bidding b ON ubc.UserId = b.UserId AND ubc.Lot_Id = b.lotId
                WHERE ubc.Lot_Id = :lotId
                GROUP BY ubc.UserId
                ORDER BY highestBid DESC";

        $query = $this->pdo->prepare($sql);
        $query->bindParam(':lotId', $lotId, PDO::PARAM_INT);

        if ($query->execute()) {
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } else {
            // Handle the error or return an appropriate value
            return [];
        }
    }


    public function save($record)
    {
        if (empty($record[$this->primaryKey])) {
            unset($record[$this->primaryKey]);
        }

        try {
            $this->insert($record);
        } catch (Exception $e) {
            $this->update($record);
        }
    }

    public function update($record)
    {

        $query = 'UPDATE ' . $this->table . ' SET ';

        $parameters = [];
        foreach ($record as $key => $value) {
            $parameters[] = $key . ' = :' . $key;
        }

        $query .= implode(', ', $parameters);
        $query .= ' WHERE ' . $this->primaryKey . ' = :primaryKey';

        $record['primaryKey'] = $record[$this->primaryKey];

        $stmt = $this->pdo->prepare($query);

        $stmt->execute($record);
    }


    public function searchCategory($searchQuery)
    {
        // Assuming you are using PDO for database operations
        $searchQuery = '%' . $searchQuery . '%'; // Add wildcard characters to search for partial matches

        $sql = "SELECT * FROM category WHERE catname LIKE :searchQuery";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':searchQuery', $searchQuery, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function searchAuctions($searchQuery)
    {
        // Assuming you are using PDO for database operations
        $searchQuery = '%' . $searchQuery . '%'; // Add wildcard characters to search for partial matches

        $sql = "SELECT DISTINCT aucId, auctionimage, catname, title, startDate, endDate FROM lot_auction WHERE title LIKE :searchQuery";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':searchQuery', $searchQuery, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function searchAuction($searchQuery)
    {
        // Assuming you are using PDO for database operations
        $searchQuery = '%' . $searchQuery . '%'; // Add wildcard characters to search for partial matches

        $sql = "SELECT * FROM auction_cat WHERE title LIKE :searchQuery";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':searchQuery', $searchQuery, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function searchLot($searchQuery)
    {
        // Assuming you are using PDO for database operations
        $searchQuery = '%' . $searchQuery . '%'; // Add wildcard characters to search for partial matches

        $sql = "SELECT * FROM lot_auction WHERE lotname LIKE :searchQuery";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':searchQuery', $searchQuery, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAuctionsByCategoryId($catId): array
    {
        $sql = "SELECT DISTINCT aucId, auctionimage, catname, title, startDate, endDate FROM lot_auction WHERE catId = :catId";
        $query = $this->pdo->prepare($sql);
        $query->bindParam(':catId', $catId, PDO::PARAM_INT);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findAllSorting($sortOrder): array
    {
        switch ($sortOrder) {
            case 'upcoming':
                $sql = "SELECT * FROM lot_auction ORDER BY datecreate DESC";
                break;
            case 'latest':
                $sql = "SELECT * FROM lot_auction ORDER BY endDate DESC";
                break;
            case 'asc':
                $sql = "SELECT * FROM lot_auction ORDER BY title ASC";
                break;
            case 'desc':
                $sql = "SELECT * FROM lot_auction ORDER BY title DESC";
                break;
            case '0-350':
                $sql = "SELECT * FROM lot_auction WHERE price BETWEEN 0 AND 350 ORDER BY price ASC";
                break;
            case '350-650':
                $sql = "SELECT * FROM lot_auction WHERE price BETWEEN 350 AND 650 ORDER BY price ASC";
                break;
            case '650-1000':
                $sql = "SELECT * FROM lot_auction WHERE price BETWEEN 650 AND 1000 ORDER BY price ASC";
                break;
            case '1000':
                $sql = "SELECT * FROM lot_auction WHERE price >= 1000 ORDER BY price ASC";
                break;
            default:
                $sql = "SELECT * FROM lot_auction ORDER BY endDate ASC"; // Default to 'upcoming'
                break;
        }

        $query = $this->pdo->prepare($sql);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findAllSort($sortOrder, $aucId): array
{
    switch ($sortOrder) {
        case 'upcoming':
            $sql = "SELECT * FROM lot_auction WHERE aucId = :aucId ORDER BY datecreate DESC";
            break;
        case 'lates':
            $sql = "SELECT * FROM lot_auction WHERE aucId = :aucId ORDER BY endDate DESC";
            break;
        case 'asc':
            $sql = "SELECT * FROM lot_auction WHERE aucId = :aucId ORDER BY lotname ASC";
            break;
        case 'desc':
            $sql = "SELECT * FROM lot_auction WHERE aucId = :aucId ORDER BY lotname DESC";
            break;
        case '0-350':
            $sql = "SELECT * FROM lot_auction WHERE aucId = :aucId AND price BETWEEN 0 AND 350 ORDER BY price ASC";
            break;
        case '350-650':
            $sql = "SELECT * FROM lot_auction WHERE aucId = :aucId AND price BETWEEN 350 AND 650 ORDER BY price ASC";
            break;
        case '650-1000':
            $sql = "SELECT * FROM lot_auction WHERE aucId = :aucId AND price BETWEEN 650 AND 1000 ORDER BY price ASC";
            break;
        case '1000':
            $sql = "SELECT * FROM lot_auction WHERE aucId = :aucId AND price >= 1000 ORDER BY price ASC";
            break;
        default:
            $sql = "SELECT * FROM lot_auction WHERE aucId = :aucId ORDER BY endDate ASC"; // Default to 'upcoming'
            break;
    }

    $query = $this->pdo->prepare($sql);
    $query->bindParam(':aucId', $aucId, PDO::PARAM_INT);
    $query->execute();

    return $query->fetchAll(PDO::FETCH_ASSOC);
}



    public function join($query, $values)
    {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($values);
        return $stmt->fetchAll();
    }

    public function findByEmail($email)
    {
        $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    private function hasBiddingEnded(string $endTime): bool
    {
        // Implement logic to check if the current time is past the specified end time
        $currentTime = new DateTime();
        $endTime = new DateTime($endTime);

        return $currentTime > $endTime;
    }

    function getMaxLotNum() {
        global $pdo; // Assuming $pdo is your database connection object
        $stmt = $pdo->prepare("SELECT MAX(lotnum) AS max_lotnum FROM lot");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
        return $result['max_lotnum'] ?: 0; // Return 0 if there are no existing lot numbers
    }

    public function findAllDistinctAuctions(): array
{
    $sql = "SELECT DISTINCT aucId, auctionimage, catname, title, startDate, endDate FROM lot_auction";
    
    $query = $this->pdo->prepare($sql);
    $query->execute();

    return $query->fetchAll(PDO::FETCH_ASSOC);
}
    
}

