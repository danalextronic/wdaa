<?php namespace CSG\Mailers;

class VerificationMailer extends BaseMailer {

	public function userComplete()
	{
		$this->view = 'emails.verifications.user_complete';
		$this->subject = 'Thanks for completing the ' . $data['package']->name;
		$this->data = $data;

		return $this;
	}

	public function evaluate($data = [])
	{
		$this->view = 'emails.verifications.new';
		$this->subject = 'You have scorecards to evaluate';
		$this->data = $data;

		return $this;
	}

	public function review($data = [])
	{
		$this->view = 'emails.verifications.review';
		$this->subject = 'There is a new scorecard to verify';
		$this->data = $data;

		return $this;
	}

	public function complete($data = [])
	{
		$this->view = 'emails.verifications.complete';
		$this->subject = 'The comparison results are available';
		$this->data = $data;

		return $this;
	}

}
