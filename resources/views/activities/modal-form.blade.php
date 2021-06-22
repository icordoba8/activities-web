<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"> Agregar actividad</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <fieldset  id="fieldset-activity" >
        <form id="form-activity" >
          <div class="row">
            <div class="col">
              <label for="Actividad" class="form-label">Actividad</label>
              <input  type="text" name="activity" autocomplete="off" class="form-control"  placeholder="">
            </div>
            <div class="col">
              <button type="submit" class="btn btn-default button-add  "> 
                <img id="button-img-activity" src=" {{asset("images/add.svg") }}" alt="" > 
              </button>
            </div>
          </div>
        </form>
        </fieldset>
        <fieldset disabled  id="fieldset-times" >
        <h5 class="title-times"><span class="badge bg-secondary">Tiempos</span></h5>
        <form id="form-times">
          <div class="row">
              <div class="col">
                  <label for="Actividad" class="form-label">Fecha</label>
                  <input type="date" required name="date_time" class="form-control"  placeholder="">
              </div>
              <div class="col">
                  <label for="Actividad" class="form-label">Horas</label>
                  <input type="number" required min="1" max="9" pattern="[1-9]+([\.,][0-9]+)?" step="0.01" name="hours" class="form-control"  placeholder="">
              </div>
              <div class="col">
                <button type="submit" class="btn btn-default button-add">
                <img src="{{asset("images/add.svg") }}" alt="" > 
              </button>
              </div>
          </div>
        </form>
        </fieldset>
        <table id="times-datatables" class="table mt-3  table ">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Fecha </th>
                    <th scope="col">Horas</th>
                    <th scope="col"></th>
                    </tr>
                </thead>
            </table>
            </fieldset>
      </div>
      <div class="modal-footer">
      
      </div>
    </div>
  </div>
</div>