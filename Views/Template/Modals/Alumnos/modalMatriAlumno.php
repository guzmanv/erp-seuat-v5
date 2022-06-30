<div class="modal fade" id="ModalFormAlumnoMatricular" data-backdrop="static" data-keyboard="true" tabindex="-1" role="dialog" aria-hidden="true">

  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
    <div class="modal-content">

      <div class="modal-header">

        <h5 class="modal-title">Matricular alumno </h5> 
        <button type="button" class="close cerrarModal" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>

      </div>

      <div class="modal-body">

        <!-- <small class="text-muted">Los campos con asterisco (<span class="required">*</span>) son obligatorios.</small> -->

        <div class="card mt-1">

          <form id="formAlumnosUp" name="formAlumnosUp" autocomplete="off">

            <input type="hidden" id="idAlumnosUp" name="idAlumnosUp">

            <div class="card-body">

                    <!-- <div class="form-group">
                      <label for="txtMatriculaIntAlumnoUp">Matricula Interna</label>
                      <input type="text" id="txtMatriculaIntAlumnoUp" name="txtMatriculaIntAlumnoUp" class="form-control" placeholder="&#xf007 Número matricula"  name="Ingresa la matricula" disabled>
                    </div> -->
                    <div class="form-group">
                      <label for="txtNombreEstUp">Estas matriculando a:</label>
                      <input type="text" id="txtNombreEstUp" name="txtNombreEstUp" class="form-control" placeholder="&#xf007 Nombre del estudiante"  name="Ingresa el nombre" disabled>
                    </div>
                    <div class="form-group">
                      <label for="txtMatriculaExtAlumnoUp">Matricula Externa</label>
                      <input type="text" id="txtMatriculaExtAlumnoUp" name="txtMatriculaExtAlumnoUp" class="form-control" placeholder="&#xf007 Número matricula"  name="Ingresa la matricula"  required>
                    </div>
                    <!-- <div class="form-group">
                        <label for="listIdPeriodosEditar">Periodo</label>
                        <select class="form-control" id="listIdPeriodosEditar" name="listIdPeriodosEditar" required >
                        
                        </select>
                    </div> -->

                    <!-- <div class="form-group">
                        <label>Estatus <span class="required">*</span></label>
                        <select class="custom-select" id="listEstatusUp" name="listEstatusUp" required>
                        <option value="1">Activo</option>
                        <option value="2">Inactivo</option>
                        </select>
                    </div> -->

            </div>
            <div class="modal-footer">
              <a class="btn btn-outline-secondary icono-color-principal btn-inline cerrarModal" href="#" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle icono-azul"></i>Cancelar</a>
              <button id="btnActionForm" type="submit" class="btn btn-primary btn-inline"><i class="fa fa-fw fa-lg fa-check-circle icono-azul"></i> Actualizar</button>
            </div>

          </form>

        </div>

      </div>

    </div>
  </div>

</div>