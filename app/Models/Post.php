<?php

namespace Models;

use Libraries\Database;

class Post
{
    /**
     * Database ORM
     * @var Database
     */
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    /**
     * Get Posts
     * @return mixed
     */
    public function getPosts()
    {
        $this->db->query('SELECT *,
                        posts.id as postId,
                        IF(users.id IS NULL,0,users.id) as userId,
                        posts.created_at as postCreated,
                        users.created_at as userCreated
                        FROM posts
                        LEFT JOIN users
                        ON posts.user_id = users.id
                        ORDER BY posts.created_at DESC');
        
        $results = $this->db->results();
        return $results;
    }

    /**
     * Add a New Post
     * @param $data
     * @return bool
     */
    public function addPost($data)
    {

        $this->db->query('INSERT INTO posts (title, body, user_id) VALUES (:title, :body, :user_id)');
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':body', $data['body']);
        $this->db->bind(':user_id', $data['user_id']);

        // Execute query
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Updates a Post
     * @param $data
     * @return bool
     */
    public function updatePost($data)
    {
        $this->db->query('UPDATE posts SET title = :title,  body = :body WHERE id = :id');
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':body', $data['body']);
        $this->db->bind(':id', $data['id']);

        // Execute query
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get the Post by ID
     * @param $id
     * @return mixed
     */
    public function getPostById($id)
    {
        $this->db->query('SELECT * FROM posts WHERE id = :id');
        $this->db->bind(':id', $id);
        $result = $this->db->result();
        return $result;
    }

    /**
     * Delete a Post
     * @param $id
     * @return bool
     */
    public function deletePost($id)
    {
        $this->db->query('DELETE FROM posts WHERE id = :id');
        $this->db->bind(':id', $id);

        // Execute query
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
}