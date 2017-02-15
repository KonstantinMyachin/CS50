            </div>
            <div class="modal fade" id="changePasswordDialog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="changePasswordDialogTitle">Change password</h4>
                  </div>
                  <form action="password.php" method="post">
                    <div class="modal-body">
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" name="currentpassword" placeholder="Current password" type="password"/>
                            </div>
                            <div class="form-group">
                                <input class="form-control" name="password" placeholder="New password" type="password"/>
                            </div>
                            <div class="form-group">
                                <input class="form-control" name="confirmation" placeholder="Confirm your password" type="password"/>
                            </div>
                        </fielset>
                    </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                      </div>
                  </form>
                </div>
              </div>
            </div>
            <div id="bottom">
                Brought to you by the number <a href="http://cdn.cs50.net/2015/fall/psets/7/pset7/pset7.html">7</a>.
            </div>

        </div>

    </body>

</html>
