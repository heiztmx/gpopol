<!-- Button trigger modal -->
<button style="display: none;" id="btnInactividad" type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  Launch demo modal
</button>

<!-- Modal -->
<div style="z-index: 10000001; margin-top: 20px;" class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Alerta de inactividad</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <p>La sesion se finalizara de forma automatica en  <span id="restante"></span></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="cerrarSesion()">Cerrar sesion</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal"  onclick="continuar()">Continuar</button>
      </div>
    </div>
  </div>
</div>