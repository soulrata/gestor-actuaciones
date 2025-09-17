Fecha: 2025-09-16

Cambio realizado:
- Se actualizó la vista `resources/views/welcome.blade.php` para renombrar y re-describir la aplicación como "Sistema de Seguimiento y Cumplimiento de Trámites".

Motivación:
- El sistema se enfoca en garantizar el seguimiento de actuaciones administrativas y el cumplimiento de reglas y plazos, por lo que la descripción pública debe reflejar ese propósito.

Resumen técnico de lo ya implementado (Kickstart):
- Migraciones core para casos, asignaciones y workflows (ajustadas para coexistir con Spatie Permission).
- Seeders: EcosystemSeeder, RolesSeeder (adaptado a Spatie), SettingsSeeder, WorkflowBaseSeeder, RoutePermissionsSeeder, AdminPermissionsSeeder.
- Actualización de `resources/views/components/layouts/app/header.blade.php` para controlar visibilidad por permiso asociado a nombre de ruta (fallback a permiso legible).
- Placeholder routes y controladores para entradas de agente/revisor/firma para evitar errores en `route()`.
- `app/Services/WorkflowEngine.php` (esqueleto) para centralizar transiciones de estado y reglas.

Siguientes pasos recomendados:
- Implementar controladores funcionales para Tickets/Revisión/Firma.
- Completar modelos y factories restantes (CaseEvent, WorkflowModel, WorkflowState, WorkflowTransition).
- Escribir tests automatizados (Pest) para validación de requests, política de casos y motor de workflow.
- Ajustes UI/UX finales y compilación de assets (`npm run build` / `composer run dev`) si se muestran cambios en frontend.

Notas:
- Todos los cambios aplicados respetan convenciones Laravel 12 y la integración con Spatie Permission.
- Si necesitás, puedo crear los tests automáticamente ahora (Feature/Unit) — decime si querés que los agregue.
