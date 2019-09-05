<?php 
spl_autoload_register(function ($class){
    require $class.'.inc';
});
 class Admin extends User implements subject{
 	private $observers=array();

 	public function addObject(addable $obj){
 		if($obj instanceof News){
 			$this->notify();
            $this->observers=null;  
 		}
 			
 		$obj->add();
 	}
 	public function deleteObject(addable $obj){
 		$obj->delete();
 	}
 	public function editObject(editable $obj){
 		$obj->edit();	
 	}
 	public function showObjects($class){
 		return $class::showAll();
 	}
 	public function search($class,$key){
 		return $class::search($key);
 	}
	
	// ==================== clients functions ======================
	public function showclientdata($id){
		$client = new Client();
		$client->setId($id);
		$client= $client->getOne();
		return $client;

	}

// ====================================================== courses functions================================================================
 public function get_course($id){
 	$course = new Course();
 	$course->setcourseid($id);
 	$course=$course->getOne();
 	return $course;
	} 
	// ================================================= Start Instructors functions =================================================	
	 public function get_instructor($id){
	 	$instructor=new Instructor();
	 	$instructor->setId($id);
	 	$instructor=$instructor->getOne();
	 	return $instructor;
	} 
// ======================== news functions ===========================	
public function get_news($id){
$news =new News();
$news->setnewsid($id);
$news=$news->getOne();
return $news;
}
//=========================branch functions =========================================
//get specific branh
public function get_branch($id){
	$branch = new Branch ();
	$branch->setbranchid($id);
   $branch = $branch->getOne();
return $branch;
}
// ===================================== Books functions =======================================
	public function showbook($id){
		$book=new Book();
		$book->setId($id);
		$book=$book->getOne();
		return $book;
	}
// ================================================= Start supers functions =================================================
 public function get_super($id){
 	$super= new Supervisor();
 	$super->setId($id);
 	$super=$super->getOne();
 	return $super;
	} 
	// ================================================= dashboard functions ================================================
	public function getBookRevenues(){
		return Book::getRevenues();
	}
	public function getCourseRevenues(){
		return Course::getRevenues();
	}
	public function getCount($class){
		return $class::getCount();
	}
	public function getBookTransactions(){
		return Book::getTransactions();
	}
	public function getCourseTransactions(){
		return Course::getTransactions();
	}
	public function getClientRegistrations(){
		return Client::getRegistrations();
	}
	public function getTopBooks(){
		return Book::getTop();
	}
	public function getTopInstructors(){
		return Instructor::getTop();
	}
	public function getTopCourses(){
		return Course::getTop();
	}
	public function calculateRevenue(){

        $db=Database::getinstance();
        $result=intval($db->select('SELECT SUM(courses.price) FROM courses,client_course Where client_course.courseid= courses.courseId'
        	,'','',0));

		$result+=intval($db->select('SELECT SUM(books.price) FROM books,client_book Where client_book.bookid= books.bookId',
			'','',0));

		$db->close();
		return strval($result);
	}
	public function getRevenuesAtMonth($date){

        $db=Database::getinstance();
        $result=intval($db->select('SELECT SUM(courses.price) FROM courses,client_course Where client_course.courseid= courses.courseId AND registerdate <=?',array($date),'',0));

		$result+=intval($db->select('SELECT SUM(books.price) FROM books,client_book Where client_book.bookid= books.bookId And purchasedate <=?
			',array($date),'',0));
		$db->close();
		return $result;
}
	// ======================================== notifications =============================================================
	public function subscribe(observer $o){
$this->observers[]=$o;
}
public function unsubscribe(observer $o){
$index=array_search($o,$this->observers);
unset($this->observers[$index]);
}

public function notify(){

	foreach ($this->observers as  $value) {
		$value->update();
	}
}
public function get_verify_unverify_clients($flag){
    
    return Client::getv_unv_clients($flag);
    
}
public function backupDatabase(){
	$db=Database::getinstance();
	$result=$db->backup();
	$db->close();
	return $result;
}
} // End Class

