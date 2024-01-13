<?php
    /*
    * Binary Search Tree
    * by MattKun
    * 12/19/23 
    */

    class Node {
        public int $key = 0;
        public $left = null;
        public $right = null;
        public int $depth = 0;
        
        function __construct(int $key, int $depth) {
            $this->key = $key;
            $this->depth = $depth;
        }
    }
    
    class BST {
        private $nodes = null;
        private int $node_count = 0;
        private int $height = 0;
        private $queue = array();
        
        private function insert(&$root, int $key, int $depth = 0) {
        
            if (is_null($root)) {
                $root = new Node($key, $depth);
                $this->node_count++;
                
                if ($depth > $this->height)
                    $this->height = $depth;
                return;
            }
            
            if ($key < $root->key) {
                $this->insert($root->left, $key, $root->depth + 1);
                return;
            }
            
            if ($key > $root->key) {
                $this->insert($root->right, $key, $root->depth + 1);
                return;
            }
            
            if ($key == $root->key)
                echo "key $key already exists \n";
                
            return;
        }
        
        public function add($key) {
            $this->insert($this->nodes, $key);
        }
        
        public function getNodes() { return $this->nodes; }
        public function getCount() { return $this->node_count; }
        public function getHeight() { return $this->height; }
        

        public function BFQueue() {
            $q = current($this->queue);
            
            if ($q && $q->left){
                $this->queue[] = $q->left;
            } else {
                $this->queue[] = null;
            }
            
            if ($q && $q->right){
                $this->queue[] = $q->right;
            } else {
                $this->queue[] = null;
            }
            
            return array_shift($this->queue);
        }
        
        // Breadth First
        public function printTree() {
            $this->queue[] = $this->nodes;
            
            $width = pow(2, $this->height);
            $space_between = $width - 1;

            for ($r=0; $r <= $this->height; $r++) {
                $row_width = pow(2, $r);
                $spacer = ' ';

                echo str_repeat($spacer, $space_between);
                
                for ($c=1; $c <= $row_width; $c++) {

                    if ($q = $this->BFQueue()) {
                        echo "$q->key";
                    } else {
                        echo 'Ø';
                    }

                    echo str_repeat($spacer, $space_between * 2 + 1);
                }

                $space_between = ceil($space_between / 2) - 1;
                echo PHP_EOL;
            }
            echo PHP_EOL.PHP_EOL;
        }
        
        public function printTreeH($root = null, $level = 0, $prefix = "Root: ") {
            if ($level === 0)
                $root = $this->getNodes();
                
            if ($root !== null) {
                echo str_repeat(" ", $level * 4) . $prefix . $root->key . PHP_EOL;
                if ($root->left !== null || $root->right !== null) {
                    $this->printTreeH($root->left, $level + 1, "L--- ");
                    $this->printTreeH($root->right, $level + 1, "R--- ");
                }
            }
        }
    }

    $keys = [5,2,1,4,5,10,3,22,34,21,15,8,55,23];
    $tree = new BST();
    
    foreach ($keys as $key) {
        $tree->add($key);
    }
    
    echo 'Binary Tree has '.$tree->getCount().' nodes with a height of '.$tree->getHeight()." \n";
    $tree->printTree();
    $tree->printTreeH();
    // print_r($tree->getNodes());
?>