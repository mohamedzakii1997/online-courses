	<?php 
spl_autoload_register(function ($class){
    require $class.'.inc';
});
class Book implements editable{
	private $name;
	private $bookId;
	private $coverImage;
	private $description;
	private $author;
	private $price;
	private $category;
	private $edition;
	private $courseId;
	private $number;

	public function setName($name){
		$this->name=$name;
	}
	public function setNumber($number){
		$this->number=$number;
	}
	
	public function setId($id){
		$this->bookId=$id;
	}
   
	public function setImg($img){
		$this->coverImage=$img;
	}
   
	
	public function setDescription($description){
		$this->description=$description;
	}
	
	public function setAuthor($author){
		$this->author=$author;
	}
	
	public function setPrice($price){
		$this->price=$price;
	}
	
	public function setCategory($category){
		$this->category=$category;
	}
	
	public function setEdition($edition){
		$this->edition=$edition;
	}
	
	public function getName(){
	 return	$this->name;
	}

	
	public function getId(){
		return $this->bookId;
	}
	public function getCourseId(){
		return $this->courseId;
	}
	
	public function getImg(){
		return $this->coverImage;
	}
	public function getNumber(){
		return $this->number;
	}
	
	public function getDescription(){
		return $this->description;
	}
	
	public function getAuthor(){
		return $this->author;
	}
	
	public function getPrice(){
		return $this->price;
	}
	
	public function getCategory(){
		return $this->category;
	}
	
	public function getEdition(){
		return $this->edition;
	}
	
	//Book Functions

	public function add()
	{
   $attr=array($this->name,
            $this->coverImage,
          $this->description,
          $this->number,
           $this->author,
            $this->price,
            $this->category,
            $this->edition,
           $this->courseId
          );
	$db=Database::getinstance();
	$db->insert('INSERT INTO books (name,coverImage,description,number,author,price,category,edition,courseId) VALUES (?,?,?,?,?,?,?,?,?)',$attr);
	$db->close();
	}

	public function edit ()
	{
		
		//require 'connection.php';	
				$sq="UPDATE books SET name=?,";
				if(!empty($this->coverImage)) $sq.="coverImage=?,";
				$sq.="description=?,number=?,author=?,price=?,category=?,edition=?,courseId=? WHERE bookId=?";
				$attr=array();
				$attr[]=$this->name;
				if(!empty($this->coverImage))$attr[]=$this->coverImage;
				$attr[]=$this->description;
				$attr[]=$this->number;
				$attr[]=$this->author;
				$attr[]=$this->price;
				$attr[]=$this->category;
				$attr[]=$this->edition;
				$attr[]=$this->courseId;
				$attr[]=$this->bookId;
		$db=Database::getinstance();
		$db->update($sq,$attr);	
		$db->close();
	}
	public function delete(){
		$db=Database::getinstance();
		$db->delete('DELETE FROM books WHERE bookId=?',array($this->bookId));
		$db->close();
	}
	public function sanitize($name,$price,$number,$category,$author,$edition,$description,$id,$cid='')
	{
		$this->name=filter_var($name,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$this->category=filter_var($category,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$this->author=filter_var($author,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$this->price=filter_var($price,FILTER_SANITIZE_NUMBER_INT);
		$this->number=filter_var($number,FILTER_SANITIZE_NUMBER_INT);
		$this->edition=filter_var($edition,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$this->description=filter_var($description,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		if(empty($cid)) $this->courseId=null;
		else $this->courseId=filter_var($cid,FILTER_SANITIZE_NUMBER_INT);
		$this->bookId=filter_var($id,FILTER_SANITIZE_NUMBER_INT);
	}
	public static function showAll(){
		 $db=Database::getinstance();
		 $books =$db->selectAll('SELECT * from books ORDER BY bookId','','Book',1);
		 $db->close();
		 return $books;
	}
	public function getOne(){
	  	$db=Database::getinstance();
	  	$row=$db->select('SELECT * FROM books WHERE bookId=?',array($this->bookId),'Book',1);
	  	$db->close();
	  	return $row;
	}
	public static function getRevenues(){
		$db=Database::getinstance();
		$result=$db->select('SELECT SUM(price) FROM client_book,books	WHERE client_book.bookid = books.bookId','','',0);
        $db->close();
        return $result;
	}
	public static function getCount(){
		$db=Database::getinstance();
		$result=$db->select('SELECT COUNT(*) FROM books','','',0);
		$db->close();
		return $result;
	}
	public static function getTransactions(){

		$db=Database::getinstance();
		$result=$db->selectAll('SELECT client_book.bookid,clientid,name,category,price,purchasedate,coverImage FROM client_book,books WHERE client_book.bookid = books.bookId ORDER BY client_book.bookid DESC limit 10','','',0);
		$db->close();
		return $result;
	}
	public static function getTop(){
		$db=Database::getinstance();
		$result=$db->selectAll('SELECT client_book.bookid,name,price,(COUNT(*)*SUM(client_book.number)) AS count FROM client_book,books WHERE client_book.bookid = books.bookId 
			GROUP BY client_book.bookid
			ORDER BY count
			 limit 10','','',0);
		$db->close();
		return $result;

	}
	public static function search($key){
		if(is_numeric($key)){
		$db=Database::getinstance();
		$all=$db->select('SELECT * FROM books WHERE bookId =?',array($key),'Book',1);
		$db->close();
		return $all;
		}else{
		$db=Database::getinstance();
		$all=$db->selectAll("SELECT * FROM books WHERE name LIKE '%".$key."%'",'','Book',1);
        $db->close();
        return $all;  
          }
	}
}