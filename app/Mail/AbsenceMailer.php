<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AbsenceMailer extends Mailable
{
  use Queueable, SerializesModels;

  public $subject = "AUSENCIA";
  public $nameFather;
  public $nameMother;
  public $nameStudent;
  public $nameGarden;

  /**
   * Create a new message instance.
   *
   * @return void
   */
  public function __construct($nameFather, $nameMother, $nameStudent, $nameGarden)
  {
    $this->nameFather = $nameFather;
    $this->nameMother = $nameMother;
    $this->nameStudent = $nameStudent;
    $this->nameGarden = $nameGarden;
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
    // DreamHome
    return $this->from('familias@dreamhome.com.co')->view('modules.assistances.MailAbsences');

    // Colchildren
    // return $this->from('logistica@colchildren.com.co')->view('modules.assistances.MailAbsences');
  }
}
