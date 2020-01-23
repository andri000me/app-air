<?php

class M_admin extends MY_Model{
    var $table = 'users';
    var $view  = 'vw_user';
    
    var $column_order = array(null,'username', 'role',null); //set column field database for datatable orderable
    var $column_search = array('username'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $order = array('id_user' => 'asc'); // default order

    public function login($username,$pass){
        $this->db->where('email',$username);
        $this->db->or_where('username',$username);
        $query = $this->db->get($this->view);

        if($query->num_rows() === 1){
            $result   = $query->row(); 
            $password = $result->password;
            if (password_verify($pass,$password)) {
                $data = array(
                    'status'       => TRUE,
                    'nama'         => $result->nama,
                    'email'        => $result->email,
                    'username'     => $result->username,
                    'password'     => $result->password,
                    'role'         => $result->role,
                    'role_name'    => $result->nama_role,
                    'created_date' => $result->date_created,
                );
            } else {
                $data['status'] = FALSE;
            }
        }else{
            $data['status'] = FALSE;
        }

        return $data;
    }

    //function untuk manajamen data user di database

    function get_datatables_query(){
        $this->db->from($this->view);

        $i = 0;

        foreach ($this->column_search as $item) // loop column
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {

                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if(count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables() {
        $this->get_datatables_query();
        if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered() {
        $this->get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all(){
        $this->db->from($this->view);
        return $this->db->count_all_results();
    }

    public function get_data_by_id($id){
        $this->db->from($this->table);
        $this->db->where('id_user',$id);
        $query = $this->db->get();

        return $query->row();
    }

    public function save($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($where, $data)
    {
        $this->db->update($this->table, $data, $where);
        return $this->db->affected_rows();
    }

    public function delete_by_id($id)
    {
        $this->db->where('id_user', $id);
        $this->db->delete($this->table);
    }

    public function update_login($data){
        $condition = "username =" . "'" . $data['username'] . "'";
        $this->db->select('last_login');
        $this->db->from('users');
        $this->db->where($condition);
        $this->db->limit(1);
        $query = $this->db->get();

        $login_data = array(
            'last_login' => $data['last_login']
        );

        if ($query->num_rows() == 1) {
            // Query to insert data in database
            $this->db->where($condition);
            $this->db->update('users', $login_data);
            if ($this->db->affected_rows() > 0) {
                return true;
            }
        } else {
            return false;
        }
    }

    public function update_data($data){
        $condition = "username =" . "'" . $data['username'] . "'";
        $this->db->select('last_modified');
        $this->db->from('users');
        $this->db->where($condition);
        $this->db->limit(1);
        $query = $this->db->get();

        $login_data = array(
            'last_modified' => $data['last_updated'],
            'modified_by'   => $data['modified_by']
        );

        if ($query->num_rows() == 1) {
            // Query to insert data in database
            $this->db->where($condition);
            $this->db->update('users', $login_data);
            if ($this->db->affected_rows() > 0) {
                return true;
            }
        } else {
            return false;
        }
    }

    public function create_data($data){
        $condition = "username =" . "'" . $data['username'] . "'";
        $this->db->select('last_modified');
        $this->db->from('users');
        $this->db->where($condition);
        $this->db->limit(1);
        $query = $this->db->get();

        $login_data = array(
            'date_created' => $data['date_created'],
            'created_by'   => $data['created_by']
        );

        if ($query->num_rows() == 1) {
            // Query to insert data in database
            $this->db->where($condition);
            $this->db->update('users', $login_data);
            if ($this->db->affected_rows() > 0) {
                return true;
            }
        } else {
            return false;
        }
    }

    public function cekSesi($username,$pass){
        $this->db->where('email',$username);
        $this->db->or_where('username',$username);
        $query = $this->db->get($this->table);

        if($query->num_rows() === 1){
            $result   = $query->row(); 
            $password = $result->password;
            if ($password == $pass) {
                $data = array(
                    'status'       => TRUE,
                    'nama'         => $result->nama,
                    'email'        => $result->email,
                    'username'     => $result->username,
                    'password'     => $result->password,
                    'role'         => $result->role,
                    'created_date' => $result->date_created,
                );
            } else {
                $data['status'] = FALSE;
            }
        }else{
            $data['status'] = FALSE;
        }

        return $data;
    }

    public function cekUserAccess($role,$menu){
        $this->db->where('role_id',$role);
        $this->db->where('menu_id',$menu);
        $query = $this->db->get('user_access_menu');

        if($query->num_rows() === 1){
            $data['status'] = TRUE;
        }else{
            $data['status'] = FALSE;
        }

        return $data;
    }

    public function changePass($user,$data){
        $this->db->where('username', $user);
        $query = $this->db->update('users', $data);

        if($query)
            return TRUE;
        else
            return FALSE;
    }

    public function softDelete($id){
        $this->db->where('id_user',$id);
        $data = array(
            'soft_delete' => '1',
        );
        $this->db->update($this->table,$data);
        return $this->db->affected_rows();
    }
}
?>