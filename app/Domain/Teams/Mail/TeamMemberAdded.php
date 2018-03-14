<?php

namespace SAASBoilerplate\Domain\Teams\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use SAASBoilerplate\Domain\Teams\Models\Team;
use SAASBoilerplate\Domain\Users\Models\User;

class TeamMemberAdded extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * User instance.
     *
     * @var User
     */
    public $user;

    /**
     * Team instance.
     *
     * @var Team
     */
    public $team;

    /**
     * Create a new message instance.
     *
     * @param User $user
     * @param Team $team
     */
    public function __construct(User $user, Team $team)
    {
        $this->user = $user;
        $this->team = $team;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Team Membership')->markdown('emails.team.member.added');
    }
}
