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
  public $NameFiles;

  /**
   * Create a new message instance.
   *
   * @return void
   */
  public function __construct($pdfOutputAcademic, $nameFiles, $pdfOutputAdministrative, $nameFile, $files, $hi, $cont, $NameFiles)
  {
    $this->pdfOutputAcademic = $pdfOutputAcademic;
    $this->pdfOutputAdministrative = $pdfOutputAdministrative;
    $this->nameFiles = $nameFiles;
    $this->nameFile = $nameFile;
    $this->files = $files;
    $this->hi = $hi;
    $this->cont = $cont;
    $this->NameFiles = $NameFiles;
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
    $emails = $this->view('modules.customers.mailInfoDaily')
      ->attachData($this->pdfOutputAcademic, $this->nameFiles)
      ->attachData($this->pdfOutputAdministrative, $this->nameFile);
    foreach ($this->files as $file) {
      $emails->attach($file, [
        "as" => $file->getClientOriginalName(),
        "mime" => $file->getClientMimeType()
      ]);
    }
    return $emails;
  }
}
