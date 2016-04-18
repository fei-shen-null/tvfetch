<div class="modal fade" id="loginModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Subscribe with email</h4>
            </div>
            <div class="modal-body">
                <form role="form">
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" class="form-control" id="email" placeholder="email">
                            <label for="uLogin" class="input-group-addon glyphicon glyphicon-envelope"></label>
                        </div>
                    </div> <!-- /.form-group -->
                    {{--<div class="checkbox">--}}
                    {{--<label>--}}
                    {{--<input type="checkbox"> Remember me--}}
                    {{--</label>--}}
                    {{--</div> <!-- /.checkbox -->--}}
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="loginModalSubmit" onclick="loginModalSubmit()"
                        class="form-control btn btn-primary">Subscribe
                </button>
            </div>
        </div>
    </div>
</div>