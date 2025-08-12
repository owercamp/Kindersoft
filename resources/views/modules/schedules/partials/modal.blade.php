<div class="modal-dialog modal-lg">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
      <h5 style="background-color: hsla(228, 79%, 53%, 0.52); padding: 1rem; color: ivory;">INFORMACIÓN DIARIA - {{config('app.name')}}</h5>
      <hr>
      <h6 style="background-color: hsla(209, 71%, 42%, 0.49); padding: 1rem; color: ivory;" id="hi"></h6>
      <p style="margin: 1rem;" id="cont"></p>
      <p style="margin: 1rem;" id="note"></p>
      <div style="max-width: fit-content; font-size: 12px; border: 1px solid hsla(26,65%,42%,0.75);">
        <p style="background-color: hsla(26, 65%, 42%, 0.75); padding: 0.3rem; color: ivory;">Archivos Adjuntos </p>
        <ul style="margin-right: 1rem;" id="list">
          <!-- dinamic list -->
        </ul>
      </div>

    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cerrar</button>
    </div>
  </div>
</div>