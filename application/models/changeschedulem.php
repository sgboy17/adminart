<?php

class Changeschedulem extends My_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function get_items_by_student_id($id)
    {
        return $this->db->select('cs.*, r.name as room_name, ch.from_time, ch.to_time, c.class_code as class_name')
        				->from($this->prefix . 'change_schedule cs')
        				->join($this->prefix . 'class c', 'c.class_id = cs.class_id')
                        ->join($this->prefix . 'class_hour ch', 'c.class_id = ch.class_id')
                        ->join($this->prefix . 'room r', 'r.room_id = ch.room_id')
        				->where('cs.deleted', 0)
                        ->where('ch.deleted', 0)
                        ->where('c.deleted', 0)
                        ->where('cs.student_id', $id)
        				->order_by('from_date DESC')
        				->get();
    }

    function get_items_by_class_id($class_id)
    {
        return $this->db->select('cs.*, r.name as room_name, ch.from_time, ch.to_time, c.class_code as class_name')
            ->from($this->prefix . 'change_schedule cs')
            ->join($this->prefix . 'class c', 'c.class_id = cs.class_id')
            ->join($this->prefix . 'class_hour ch', 'c.class_id = ch.class_id')
            ->join($this->prefix . 'room r', 'r.room_id = ch.room_id')
            ->where('cs.deleted', 0)
            ->where('ch.deleted', 0)
            ->where('c.deleted', 0)
            ->where('cs.class_id', $class_id)
            ->order_by('from_date DESC')
            ->get();
    }

    function get_item_by_student_class($student_id, $class_id, $date)
    {
        return $this->db->where('student_id', $student_id)
                ->where('class_id', $class_id)
                ->where('branch_id', $this->session->userdata('branch'))
                ->where('deleted', 0)
                ->where('to_date', $date)
                ->get($this->prefix . 'change_schedule')
                ->row_array();
    }

}