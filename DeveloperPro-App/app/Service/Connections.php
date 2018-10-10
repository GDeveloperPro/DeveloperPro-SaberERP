<?php
    /**
     * Created by DeveloperPro ®.
     * User: Gilberto Guerrero Quinayas
     * Date: 25/09/2018
     * Time: 5:35 PM
     */
    
    namespace Service;


    /**
     * Class Connections
     *
     * @package Service
     */
    class Connections
    {
        /**
         * @var resource
         */
        private $connect;
    
        /**
         * Connections constructor.
         */
        public function __construct()
        {
            $this->connect = pg_connect('host=' . getenv('DB_PG_HOST') . ' dbname=' . getenv('DB_PG_NAME') . ' user=' . getenv('DB_PG_USER') . ' password=' . getenv('DB_PG_PASS')) or die('Unable to connect: ' . pg_last_error());
            pg_client_encoding($this->connect);
        }
    
        /**
         * @return resource
         */
        public function getConnect()
        {
            return $this->connect;
        }
    
        /**
         * @param $sql
         */
        public function simpleQuery($sql)
        {
            pg_query($this->connect, $sql);
        }
    
        /**
         * @param $sql
         *
         * @return mixed
         */
        public function simpleQueryId($sql)
        {
            $result = pg_query($this->connect, $sql);
        
            $row = pg_fetch_row($result);
        
            return $row[0];
        }
    
        /**
         * @param $sql
         *
         * @return resource
         */
        public function complexQuery($sql)
        {
            return pg_query($this->connect, $sql);
        }
    
        /**
         * @param $sql
         *
         * @return array|int
         */
        public function complexQueryNonAssociative($sql)
        {
            $result = pg_query($this->connect, $sql);
        
            if (pg_num_rows($result) > 0)
                return pg_fetch_assoc($result);
            else
                return 0;
        }
    
        /**
         * @param $sql
         *
         * @return array|int
         */
        public function complexQueryAssociative($sql)
        {
            $result = pg_query($this->connect, $sql);
        
            if (pg_num_rows($result) > 0)
                while ($row = pg_fetch_assoc($result)) {
                    $data[] = $row;
                }
            else
                $data = 0;
        
            return $data;
        }
    }