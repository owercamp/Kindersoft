<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Storage;

class MessageInfoDaily extends Mailable
{
  use Queueable, SerializesModels;

  public $subject = "INFORMACIÓN DIARIA";
  public $pdfOutputAcademic;
  public $pdfOutputAdministrative;
  public $nameFiles;
  public $nameFile;
  public $files;
  public $hi;
  public $cont;
  public $emoji;
  public $NameFiles;
  public $firm;
  public $position;

  /**
   * Create a new message instance.
   *
   * @return void
   */
  public function __construct($pdfOutputAcademic, $nameFiles="", $pdfOutputAdministrative, $nameFile="", $files, $hi, $cont, $emoji,$NameFiles,$firm,$position)
  {
    $this->pdfOutputAcademic = $pdfOutputAcademic;
    $this->pdfOutputAdministrative = $pdfOutputAdministrative;
    $this->nameFiles = $nameFiles;
    $this->nameFile = $nameFile;
    $this->files = $files;
    $this->hi = $hi;
    $this->cont = $cont;
    $this->emoji = $emoji;
    $this->NameFiles = $NameFiles;
    $this->firm = $firm;
    $this->position = $position;
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
    $emails = $this->view('modules.customers.mailInfoDaily')
      ->from("logistica@colchildren.com.co");
      if ($this->nameFiles != "") {
        $emails->attachData($this->pdfOutputAcademic, $this->nameFiles);
      }
      if ($this->nameFile != "") {
        $emails->attachData($this->pdfOutputAdministrative, $this->nameFile);
      }
      if ($this->files) {
        foreach ($this->files as $file) {
          $emails->attach($file, [
            "as" => $file->getClientOriginalName(),
            "mime" => $file->getClientMimeType()
          ]);
        }
      }
    return $emails;
  }
}
