<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use phpDocumentor\Reflection\Types\This;

class MessageFactureGenerate extends Mailable
{
  use Queueable, SerializesModels;

  public $subjects;
  public $code;
  public $dateFinal;
  public $nameFat;
  public $nameMot;
  public $val;
  public $pdfOutput;
  public $namefile;
  public $countData;
  public $infoGarden;

  /**
   * Create a new message instance.
   *
   * @return void
   */
  public function __construct($code, $dateFinal, $nameFat, $nameMot, $val, $pdf, $namefile, $subjects, $countData, $infoGarden)
  {
    $this->code = $code;
    $this->dateFinal = $dateFinal;
    $this->nameFat = $nameFat;
    $this->nameMot = $nameMot;
    $this->val = $val;
    $this->pdf = $pdf;
    $this->namefile = $namefile;
    $this->subjects = $subjects;
    $this->countData = $countData;
    $this->infoGarden = $infoGarden;
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
    return $this->view('modules.customers.mailPayOrder')
      ->subject($this->subjects)
      ->attachData($this->pdf, $this->namefile);
  }
}
