<?php  
	/**
	 * 
	 */
	class Post
	{
		private $conn;
		private $table = 'posts';

		//POST properties
		public $id;
		public $title;
		public $body;
		public $created_at;
		public $user_id;
		public $category_id;
		
		public $author;
		public $category_name;

		public function __construct($db)
		{
			$this->conn = $db;
		}


		public function getAllPost(){
			$query = " 	SELECT c.name as category_name,
								u.lastName as author,
								p.id,
								p.category_id,
								p.title,
								p.body,
								p.created_at,
								p.user_id
						FROM $this->table as p 
						LEFT JOIN categories as c ON p.category_id = c.id
						JOIN users as u ON p.user_id = u.id 
						ORDER BY p.created_at DESC";

			$stmt = $this->conn->prepare($query);

			$stmt->execute();

			return $stmt;
		}

		public function getPostById(){
			$query = " 	SELECT c.name as category_name,
								u.lastName as author,
								p.id,
								p.category_id,
								p.title,
								p.body,
								p.created_at,
								p.user_id
						FROM $this->table as p 
						LEFT JOIN categories as c ON p.category_id = c.id
						JOIN users as u ON p.user_id = u.id 
						WHERE p.id = ?
						LIMIT 0,1";
			$stmt = $this->conn->prepare($query);

			$stmt->bindParam(1, $this->id);
			$stmt->execute();

			$row = $stmt->fetch(PDO::FETCH_ASSOC);

			$this->title = $row['title'];
			$this->body = $row['body'];
			$this->category_name = $row['category_name'];
			$this->author = $row['author'];
			$this->category_id = $row['category_id'];
		}

		public function create(){
			$query = "INSERT INTO $this->table SET 
						title = :title,
						body = :body,
						category_id = :category_id,
						user_id = :user_id";
			$stmt = $this->conn->prepare($query);
			
			$this->title = htmlspecialchars(strip_tags($this->title));
			$this->body = htmlspecialchars(strip_tags($this->body));
			$this->category_id = htmlspecialchars(strip_tags($this->category_id));
			$this->user_id = htmlspecialchars(strip_tags($this->user_id));

			$stmt->bindParam(':title', $this->title);
			$stmt->bindParam(':body', $this->body);
			$stmt->bindParam(':category_id', $this->category_id);
			$stmt->bindParam(':user_id', $this->user_id);

			if($stmt->execute()){
				return true;
			}

			return false;
		}

		public function update(){
			$query = "UPDATE $this->table SET 
							title = :title,
							body = :body,
							category_id = :category_id,
							user_id = :user_id
					WHERE id = :id";

			$stmt = $this->conn->prepare($query);
						
			$this->id = htmlspecialchars(strip_tags($this->id));
			$this->title = htmlspecialchars(strip_tags($this->title));
			$this->body = htmlspecialchars(strip_tags($this->body));
			$this->category_id = htmlspecialchars(strip_tags($this->category_id));
			$this->user_id = htmlspecialchars(strip_tags($this->user_id));

			$stmt->bindParam(':id', $this->id);
			$stmt->bindParam(':title', $this->title);
			$stmt->bindParam(':body', $this->body);
			$stmt->bindParam(':category_id', $this->category_id);
			$stmt->bindParam(':user_id', $this->user_id);

			if($stmt->execute()){
				return true;
			}

			return false;
		}

		public function delete(){
			$query = "DELETE FROM $this->table WHERE id = :id";
			$stmt = $this->conn->prepare($query);
						
			$this->id = htmlspecialchars(strip_tags($this->id));
			$stmt->bindParam(':id', $this->id);

			if($stmt->execute()){
				return true;
			}

			printf("Error: %s\n", $stmt->error);
			return false;
		}

	}
?>