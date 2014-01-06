<?php
class Cache{

    public function Cache( $config = NULL ){
        switch(CACHE_DRIVER){
            case "memcache":
                $this->_diver = new Cache_memcache( $config );
        }
    }

    public function get( $id ){
        return $this->_diver->get( $id );
    }

    public function set( $id, $data, $ttl = 60 ){
        return $this->_diver->set( $id, $data, $ttl );
    }

    public function delete( $id ){
        return $this->_diver->delete( $id );
    }

    public function clean( ){
        return $this->_diver->clean( );
    }

    public function get_metadata( $id ){
        return $this->_diver->get_metadata( $id );
    }

}