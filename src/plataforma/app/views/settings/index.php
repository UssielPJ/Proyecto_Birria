<?php require_once __DIR__ . "/partials/head.php" ?>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Configuración del Sistema</h1>
    </div>

    <div class="row">
        <!-- Configuración General -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Configuración General</h6>
                </div>
                <div class="card-body">
                    <form action="/settings/update-general" method="POST">
                        <div class="form-group">
                            <label for="school_name">Nombre de la Institución</label>
                            <input type="text" class="form-control" id="school_name" name="school_name" 
                                value="<?php echo $settings['school_name'] ?? ''; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="school_address">Dirección</label>
                            <input type="text" class="form-control" id="school_address" name="school_address" 
                                value="<?php echo $settings['school_address'] ?? ''; ?>">
                        </div>
                        <div class="form-group">
                            <label for="contact_email">Email de Contacto</label>
                            <input type="email" class="form-control" id="contact_email" name="contact_email" 
                                value="<?php echo $settings['contact_email'] ?? ''; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Teléfono</label>
                            <input type="text" class="form-control" id="phone" name="phone" 
                                value="<?php echo $settings['phone'] ?? ''; ?>">
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Configuración Académica -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Configuración Académica</h6>
                </div>
                <div class="card-body">
                    <form action="/settings/update-academic" method="POST">
                        <div class="form-group">
                            <label for="current_period">Periodo Actual</label>
                            <input type="text" class="form-control" id="current_period" name="current_period" 
                                value="<?php echo $settings['current_period'] ?? ''; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="enrollment_open">Estado de Inscripciones</label>
                            <select class="form-control" id="enrollment_open" name="enrollment_open">
                                <option value="1" <?php echo ($settings['enrollment_open'] ?? '') == '1' ? 'selected' : ''; ?>>Abiertas</option>
                                <option value="0" <?php echo ($settings['enrollment_open'] ?? '') == '0' ? 'selected' : ''; ?>>Cerradas</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="min_attendance">Asistencia Mínima Requerida (%)</label>
                            <input type="number" class="form-control" id="min_attendance" name="min_attendance" 
                                value="<?php echo $settings['min_attendance'] ?? '80'; ?>" min="0" max="100">
                        </div>
                        <div class="form-group">
                            <label for="passing_grade">Calificación Mínima Aprobatoria</label>
                            <input type="number" class="form-control" id="passing_grade" name="passing_grade" 
                                value="<?php echo $settings['passing_grade'] ?? '70'; ?>" min="0" max="100">
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Configuración de Notificaciones -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Configuración de Notificaciones</h6>
                </div>
                <div class="card-body">
                    <form action="/settings/update-notifications" method="POST">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email_notifications">Notificaciones por Email</label>
                                    <select class="form-control" id="email_notifications" name="email_notifications">
                                        <option value="1" <?php echo ($settings['email_notifications'] ?? '') == '1' ? 'selected' : ''; ?>>Activadas</option>
                                        <option value="0" <?php echo ($settings['email_notifications'] ?? '') == '0' ? 'selected' : ''; ?>>Desactivadas</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="smtp_host">Servidor SMTP</label>
                                    <input type="text" class="form-control" id="smtp_host" name="smtp_host" 
                                        value="<?php echo $settings['smtp_host'] ?? ''; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="smtp_user">Usuario SMTP</label>
                                    <input type="text" class="form-control" id="smtp_user" name="smtp_user" 
                                        value="<?php echo $settings['smtp_user'] ?? ''; ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="smtp_password">Contraseña SMTP</label>
                                    <input type="password" class="form-control" id="smtp_password" name="smtp_password" 
                                        value="<?php echo $settings['smtp_password'] ?? ''; ?>">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar Configuración</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . "/partials/footer.php" ?>