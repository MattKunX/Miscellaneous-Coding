#include <iostream>
#include <memory>

class DoublyLinkedList {

    struct Node {
        std::unique_ptr<Node> pNext;
        std::unique_ptr<Node> pPrev;
        int data = 0;
    };

    std::unique_ptr<Node> head; // first node of the list
    std::unique_ptr<Node> tail; // last node of the list

public:
    DoublyLinkedList();

    // enqueue - add to back
    // dequeue - remove from front

    // add to front of list
    void Add(int item);
};

DoublyLinkedList::DoublyLinkedList() {
    this->head = nullptr;
    this->tail = nullptr;
}

void DoublyLinkedList::Add(int item) {
    std::unique_ptr<Node> newNode(new Node);
    newNode->pNext = std::move(this->head); // point new node to current head (font node)
    newNode->data = item;
    
    // this->head->pPrev = ?;
    this->head = std::move(newNode); // move new node to font

    // Debug
    std::cout << head.get() << ": " << head.get()->data;
    if (head.get()->pNext)
        std::cout << " Prev: " << head.get()->pNext.get() << ": " << head.get()->pNext.get()->data;
    std::cout << std::endl;
}

// LIFO
class SinglyLinkedList {

public:
    struct Node {
        std::unique_ptr<Node> upNext;
        int data = 0;
    };

private:
    std::unique_ptr<Node> upHead; // first node of the list
    Node *pTail; // last node of the list
    Node *iterator;

public:
    SinglyLinkedList();
    ~SinglyLinkedList();

    SinglyLinkedList& operator++();

    Node* first();
    Node* last();
    Node* current();
    Node* end();
    Node* find(int value);
    int current_value();
    
    // add to front of list
    void add(int item);
    bool remove(int value);

    // move iterator forward one node
    bool next();
    void reset_iterator();
};

SinglyLinkedList::SinglyLinkedList() {
    this->upHead = nullptr;
    this->pTail = nullptr;
    this->iterator = nullptr;
}

// prevent stackoverflow of unique_ptr from std::default_delete 
SinglyLinkedList::~SinglyLinkedList() {
    while (this->upHead) {
        auto next = std::move(upHead->upNext);
        this->upHead = std::move(next); 
    } 
}

SinglyLinkedList& SinglyLinkedList::operator++() {
    this->next();
    return *this;
}

SinglyLinkedList::Node* SinglyLinkedList::first() {
    return this->upHead.get();
}

SinglyLinkedList::Node* SinglyLinkedList::last() {
    return this->pTail;
}

SinglyLinkedList::Node* SinglyLinkedList::current() {
    return this->iterator;
}

SinglyLinkedList::Node* SinglyLinkedList::end() {
    return nullptr;
}

SinglyLinkedList::Node* SinglyLinkedList::find(int value) {
    this->reset_iterator();

    while (this->iterator->data != value && this->next()) {}

    Node *node = this->iterator;
    this->reset_iterator();
    return node;
}

int SinglyLinkedList::current_value() {
    return this->iterator->data;
}

void SinglyLinkedList::add(int item) {
    std::unique_ptr<Node> newNode(new Node);
    newNode->upNext = std::move(this->upHead); // point new node to current head (font node)
    newNode->data = item;
    
    this->upHead = std::move(newNode); // move new node to font
    this->iterator = this->upHead.get();

    // if first node (aka always last)
    if (!this->pTail) {
        this->pTail = this->upHead.get();
    }

    // Debug
    std::cout << upHead.get() << ": " << upHead.get()->data << " Added Node" << std::endl;
}

bool SinglyLinkedList::remove(int value) {
    this->reset_iterator();

    Node *prev = nullptr;

    do {
        if (this->iterator->data == value) {
            
            if (prev) {
                if (this->pTail == this->iterator)
                    this->pTail = prev;

                if (this->iterator->upNext)
                    prev->upNext = std::move(this->iterator->upNext);
                else
                    prev->upNext.reset();

            } else { // first node
                if (this->iterator->upNext)
                    this->upHead = std::move(this->iterator->upNext);
                else
                    this->upHead.reset();
            }

            this->reset_iterator();
            return true;
        }
        
        prev = this->iterator;
    } while (this->next());

    this->reset_iterator();
    return false;
}

bool SinglyLinkedList::next() {
    if (this->iterator) {
        if (this->iterator->upNext){
            this->iterator = this->iterator->upNext.get();
            return true;
        }
        this->iterator = nullptr;
    }
    return false;
}

void SinglyLinkedList::reset_iterator() {
    this->iterator = this->upHead.get();
}

int main() {
    std::cout << "Singly Linked List" << std::endl;

    SinglyLinkedList list;

    list.add(5);
    list.add(10);
    list.add(600);
    list.add(33);
    list.add(9);

    std::cout << std::endl << "do-while loop:" << std::endl;

    do {
        std::cout << list.current_value() << " -> ";
    } while (list.next());
    
    list.reset_iterator();

    std::cout << std::endl << std::endl;

    int r = 9;
    SinglyLinkedList::Node *removed_node = list.find(r);
    std::cout << "Remove " << r << ": " << list.remove(r) << std::endl;
    std::cout << r << " value address check: " << removed_node << ": " << removed_node->data << std::endl;

    std::cout << std::endl << "for loop:" << std::endl;

    for (; list.current() != list.end(); ++list) {
        std::cout << list.current() << ": " << list.current_value() << std::endl;
    }
    
    std::cout << std::endl;

    std::cout << "first: " << list.first() << " " << list.first()->data
            << " last: " << list.last() << " " << list.last()->data
            << std::endl;

    std::cout << std::endl << "search:" << std::endl;

    SinglyLinkedList::Node* found = list.find(600);
    std::cout << "found: " << found << ": " << found->data << std::endl;

    SinglyLinkedList::Node* notfound = list.find(2);
    if (!notfound)
        std::cout << "2 not found: " << notfound << std::endl;


    return 0;
}