<?php
class Member {
    /** @var mysqli */
    protected $db;
    /** @var User */
    protected $user;
    public function __construct(mysqli $db, User $user){
        $this->db = $db;
        $this->user = $user;
    }

    public function upsert($fname, $lname, $email, $address, $zipcode, $city, $phone, $uid){
        $user = $this->user->get_profile($uid);
        if (empty($user)) {
            return $this->update($fname, $lname, $email, $address, $zipcode, $city, $phone, $uid);
        }
    }

    protected function update($fname, $lname, $email, $address, $zipcode, $city, $phone, $uid){
		$this->cleanMyStuff($fname);
		$this->cleanMyStuff($lname);
		$this->cleanMyStuff($email);
		$this->cleanMyStuff($address);
		$this->cleanMyStuff($zipcode);
		$this->cleanMyStuff($city);
		$this->cleanMyStuff($phone);
		$this->cleanMyStuff($uid);

        $query = "UPDATE users SET uemail  = '$email',
				fname = '$fname',
                lname = '$lname',
                address = '$address',
                zipcode = '$zipcode',
                city = '$city',
                phone = '$phone'
           WHERE uid = $uid";
        return $this->db->query($query);
    }

	protected function cleanMyStuff(&$in = ""){
		$in = mysqli_real_escape_string($this->db, $in);
	}
}
