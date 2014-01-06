<?php
class ProductCategories
{
    private $conn;

    public function __construct() {
        global $connection;
        $this->conn = $connection;
    }

    public function __destruct() {
    }
    
    /**
     * 获取所分类，可以指定父类ID。
     * @param type $pid 父类ID
     * @return type
     */
    public function getCategories($pid = 0){
        $return = array();
        $sql = 'SELECT * FROM product_categories WHERE parent_id = '.(int)$pid.' ';
        $cursor = exequery( $this->conn, $sql );
        while( $ROW = mysql_fetch_array($cursor) ){
            if($this->isParent($ROW['id'])){
                $temp = $this->getCategories($ROW['id']);
                array_merge($return, $temp);
            }
            array_push($return, $ROW);
            //$return[] = $ROW;
        }
        return $return;
    }

    /**
     * 判断是否自己有下分类
     * @param type $id
     * @return boolean
     */
    public function isParent($id){
        $return = false;
        $sql = 'SELECT * FROM product_categories WHERE parent_id = '.(int)$id.' ';
        $cursor = exequery( $this->conn, $sql );
        if( $ROW = mysql_fetch_array($cursor) ){
            $return = true;
        }
        return $return;
    }
    
    /**
     * 获取一条分类记录
     * @param type $id 分类的ID
     * @return type 一条分类记录的信息
     */
    public function getCategory($id){
        $return = array();
        $sql = 'SELECT * FROM product_categories WHERE id = '.(int)$id.' ';
        $cursor = exequery( $this->conn, $sql );
        while( $ROW = mysql_fetch_array($cursor) ){
            $return = $ROW;
        }
        return $return;
    }
    
    /**
     * 获取所有分类
     * @return type
     */
    public function getAllCategories(){
        $return = array();
        $sql = 'SELECT * FROM product_categories ORDER BY sort_no,id ';
        $cursor = exequery( $this->conn, $sql );
        while( $ROW = mysql_fetch_array($cursor) ){
            $return[] = $ROW;
        }
        return $return;
    }
    
    public function getCategoiresIDs($id){
        $return = $id.",";
        $sql = 'SELECT * FROM product_categories WHERE parent_id='.(int)$id.' ORDER BY id ';
        $cursor = exequery( $this->conn, $sql );
        while( $ROW = mysql_fetch_array($cursor) ){
            if($this->isParent($ROW['id'])){
                $return = $return .trim($this->getCategoiresIDs($ROW['id']),',').',';
            }else{
                $return = $return .$ROW['id'].',';
            }
        }
        return $return;
    }
}