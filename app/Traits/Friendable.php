<?php 

namespace App\Traits;
use App\Friendship;

trait Friendable{
	
	public function add_friend($user_requsted_id)
	{
		if($this->id === $user_requsted_id)
		{
			return 0;
		}

		if($this->has_pending_friend_requests_sent_to($user_requsted_id) === 1)
		{
			return "Already sent a friend request";
		}

		if($this->is_friends_with($user_requsted_id) === 1){
			return "Already friends";
		}

		if($this->has_pending_friend_requests_from($user_requsted_id) === 1)
		{
			return $this->accept_friend($user_requsted_id);
		}

		$Friendship = Friendship::create([
				'requester'			=>	$this->id,
				'user_requested'	=>	$user_requsted_id
			]);

		if($Friendship){
			return 1;	//response()->json($Friendship,200);
		}
		
		return 0;	//response()->json('Fail',501);
	}

	public function accept_friend($requester)
	{
		
		if($this->has_pending_friend_requests_from($requester) === 0)
		{
			return 0;
		}


		$Friendship = Friendship::where('requester', $requester)
									->where('user_requested', $this->id)
									->first();

		if($Friendship)
		{
			$Friendship->update([
				'status'	=> 1
				]);
			return 1;	//response()->json("OK",200);
		}
		return 0;	//response()->json('Fail',501);
	}

	public function friends(){
		$friends = array();

		$f1 = Friendship::where('status',1)
							->where('requester', $this->id)
							->get();

		foreach ($f1 as $friendship) :
			array_push($friends, \App\User::find($friendship->user_requested));
		endforeach;

		$friends2 = array();

		$f2 = Friendship::where('status',1)
							->where('user_requested', $this->id)
							->get();

		foreach ($f2 as $friendship) :
			array_push($friends2, \App\User::find($friendship->requester));
		endforeach;

		return array_merge($friends, $friends2);
	}

	public function pending_friend_requests(){
		$user = array();

		$f1 = Friendship::where('status', 0)
						->where('user_requested',$this->id)
						->get();


		foreach ($f1 as $friendship) :
			array_push($user, \App\User::find($friendship->requester));
		endforeach;

		return $user;
	}

	public function frinds_ids(){
		return collect($this->friends())->pluck('id')->toArray();
	}

	public function is_friends_with($user_id)
	{
		if(in_array($user_id, $this->frinds_ids()))
		{
			return 1;	//response()->json('true', 200);
		}
		else{
			return 0;	//response()->json('false', 200);
		}
	}


	public function pending_friend_requests_ids(){
		return collect($this->pending_friend_requests())->pluck('id')->toArray();
	}


	public function pending_friend_requests_sent(){

		$user = array();

		$friendship = Friendship::where('status', 0)
						->where('requester',$this->id)
						->get();


		foreach ($friendship as $friendship) :
			array_push($user, \App\User::find($friendship->user_requested));
		endforeach;

		return $user;
	}

	public function pending_friend_requests_sent_ids(){
		return collect($this->pending_friend_requests_sent())->pluck('id')->toArray();
	}

	public function has_pending_friend_requests_from($user_id)
	{
		if(in_array($user_id, $this->pending_friend_requests_ids()))
		{
			return 1;	//response()->json('true', 200);
		}
		else{
			return 0;	//response()->json('false', 200);
		}
	}

	public function has_pending_friend_requests_sent_to($user_id)
	{
		if(in_array($user_id, $this->pending_friend_requests_sent_ids()))
		{
			return 1;
		}
		else{
			return 0;
		}
	}

}

 ?>