<?php 



$activacion = isset($_POST["activacion"]) ? $_POST["activacion"] : "";
$obj = new generales();
// print_r($activacion);
if ($activacion == "bloquear" || $activacion == "desbloquear") {
	$obj->activar_liquidaciones($activacion);
}
class generales
{
	


	public function reparar_utf8($palabra)
	{
		$reparado="";
		if(!mb_detect_encoding($palabra,"UTF-8",true)){
			$reparado = utf8_encode($palabra);
		}else{
			$reparado=	$palabra;
		}
		return $reparado;
	}
	public function fecha_bien($fecha)
	{
		$meses= array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		$mifecha = explode("-", $fecha);
		$lafecha=$mifecha[2]."-".$meses[$mifecha[1]-1]."-".$mifecha[0];

		return $lafecha;
	}

	public function fecha_bd($fecha)
	{
		$meses= array ("Enero" =>"01","Febrero" =>"02","Marzo" => "03","Abril" =>"04","Mayo" =>"05","Junio" =>"06","Julio" =>"07","Agosto" =>"08","Septiembre" =>"09","Octubre" =>"10","Noviembre" =>"11","Diciembre" =>"12");
		$mifecha = explode("-", $fecha);
		$lafecha=$mifecha[2].".".$meses[$mifecha[1]].".".$mifecha[0];

		return $lafecha;
	}

	public function query_permisos_especiales($conexion,$id_usuario,$id_permiso,$tabla, $fecha)
	{
		$query_modi="SELECT * FROM ".$tabla." WHERE MES = '$fecha'  ";
		$where_estacion ="";
		$where_elaboro ="";
		$where_estatus ="";
		$query = "SELECT * FROM ".$tabla." WHERE MES  = '$fecha' ";
		
		$contador = 0;
		$select_permisos_especiales = "SELECT * FROM PERMISOS_ESPECIALES  WHERE  IDUSUARIO = '$id_usuario' AND PERMISO = '$id_permiso'";
		$permisos_especiales = ibase_query($conexion,$select_permisos_especiales);
		while ($per = ibase_fetch_assoc($permisos_especiales)) {
			if ($per["INPUT"] == "peres_estacion") {
				(int) $per["PERMISO_ESPECIAL"];
				$where_estacion.= " SUCURSAL = ".$per["PERMISO_ESPECIAL"]." OR";

			}
			if ($per["INPUT"] == "peres_elaboro") {
				$where_elaboro .= " ELABORO = '".$per["PERMISO_ESPECIAL"]. "' OR";
			}
			if ($per["INPUT"] == "peres_estatus"){
				$where_estatus .= " ESTADO = '".$per["PERMISO_ESPECIAL"]. "' OR";
			}
			$contador++;	
		}

		ibase_free_result($permisos_especiales); 
		ibase_close($conexion);
		if ($contador > 0) {

			if ($where_estacion != "") {
				$where_estacion = substr ($where_estacion, 0, strlen($where_estacion) - 1);
				$where_estacion = substr ($where_estacion, 0, strlen($where_estacion) - 1);
				$where_estacion = "AND (".$where_estacion.") ";
			}else{
				$where_estacion="";
			}
			
			if ($where_elaboro  != "") {
				$where_elaboro = substr ($where_elaboro, 0, strlen($where_elaboro) - 1);
				$where_elaboro = substr ($where_elaboro, 0, strlen($where_elaboro) - 1);
				$where_elaboro = "AND (".$where_elaboro." ) ";
			}
			if($where_estatus != "")
			{
				$where_estatus = substr ($where_estatus, 0, strlen($where_estatus) - 1);
				$where_estatus = substr ($where_estatus, 0, strlen($where_estatus) - 1);
				$where_estatus = "AND (".$where_estatus.") ";
			}else{
				$where_estatus ="";
			}


			$query_final = $query_modi."".$where_estacion."".$where_elaboro."".$where_estatus;

			return $query_final;
		}else{
			return $query;
		}
	}

	public function activar_liquidaciones($opcion)
	{
		include '../ConexionADMON.php';
		$obj = new conexionADMON();
		include '../conexion.php';
		$objc = new conexion();
		$CapturarDevoluciones = "";
		$RestringirLiquidaciones ="";
		$RestringirLiquidacionesM ="";
		if ($opcion  == "bloquear") {

			$CapturarDevoluciones = "No";
			$RestringirLiquidaciones ="Si";
			$RestringirLiquidacionesM ="Si";
		}else{
			$CapturarDevoluciones = "Si";
			$RestringirLiquidaciones ="No";
			$RestringirLiquidacionesM ="No";
		}

		$listavar="PosicionCliente // Posición Clave Cliente en Tarjetas 
		LongitudCliente // Longitud Clave Cliente en Tarjetas
		PosicionVehiculo // Posición Clave Vehiculo en Tarjetas
		LongitudVehiculo // Longitud Clave Vehiculo en Trajetas
		ImpresoraTicket // Impresora de Tickets de Tarjetas
		IvaCombustible // Tasa de Iva de Combustible
		DiasCuponesVenc // Dias para Vencimiento de Cupones //  // 365
		DiasFacturaContado // Dias anteriores para Facturas de Contado //  // 5
		ConceptoFactCupones // Concepto Estándar para Facturación de Cupones
		ConceptoFactCredito // Concepto Estándar para Facturación de Credito
		CombustibleDefFacc // Combustible Default en Factura de Cupones
		MaximoTurnosLiq // Turnos por día en Liquidaciones // // 3
		AuxiliarValesDefault // Auxliar de Vales Default
		AuxiliarCuponesDefault // Auxliar de Cupones Default
		PolizaLiqDia // Poliza de Liquidaciones por Día // Si;No // No
		CapturarDevoluciones // Capturar Devoluciones en Liquidaciones // Si;No // ".$CapturarDevoluciones."
		ValidarValesyCupones // Validar Vales y Cupones en Liquidaciones // Si;No // Si
		PermitirMovimientosAnteriores // Registrar Movimientos con Fechas Anteriores // Si;No // No
		ImprimirCuponesFact // Imprimir Cupones al Facturar // Si;No // Si
		ClienteSagarpa // Clave de Cliente SAGARPA
		CargoSagarpaContado // Cargo a Cliente Sagarpa en Facturas de Contado // Si;No // Si
		DieselSagarpa // Clave de Diesel SAGARPA
		UtilizarReferencia // Utilizar Referencia en Vales de Crédito // Si;No // No
		DespachadorVales // Despachador en Vales de Crédito // Si;No // No
		IslaVales // Isla en Vales de Crédito // Si;No // No
		ImprimirPagareFaltantes // Imprimir Pagaré en Liquidaciones (Faltantes) // Si;No // Si
		AuxiliarLiq // Turno Auxiliar en Liquidaciones 
		CostoCombustiblesAlma // Costo de Combustibles del Almacén // Si;No // Si
		CostoProductosAlma // Costo de Productos del Almacén // Si;No  // Si
		DigitosCupon // No. Digitos en Folio del Cupón  
		FolioFacturaUnico // Folio Unico para todas las Facturas // No;Si // No
		ValidaSaldoTarjetaCredito // Validar Saldo Tarjeta Credito // Si;No // Si
		ValidaCuponesImpresos // Validar Cupones Impresos // Si;No // Si
		CorteTurnoEnLinea // Cortes Directos de Dispensarios // Si;No // No
		SerieEnBarrasCupones // El código de barras de cupones contiene la serie // No;Si // No
		FolioVolumetricoVales // Folio Volumetrico en Vales // No;Si // No
		ClaveProveedorPemex // Clave del Proveedor PEMEX  
		SerieCompraPemex // Serie de Compra PEMEX en Inventarios
		SubsidioInbursa // Activar Subsidio Inbursa en Facturas // Si;No // No
		ClienteInbursa // Clave del Cliente INBURSA
		CargoInbursaContado // Cargo a Cliente Inbursa en Facturas de Contado // Si;No // Si
		TipoMovCargoVales // Tipo de Movimiento en CXC para Cargos Directos por Vales
		MaxFoliosVolumetricos // No. máximo de Folios Volumetricos en Facturas 
		AcumularOCCPemex // Acumular Otros Costos en Compra Pemex // Si;No // No
		SerieOtrosCostos // Serie para Facturas de Otros Costos en Compra Pemex // // OG
		EtiquetaFoliosVolumetricos // Etiqueta Folios Volumetricos en Facturas
		RestringirLiquidaciones // Restringir Captura de Liquidaciones // Si;No // ".$RestringirLiquidaciones."
		ConceptoDeposito // Concepto del depósito Monedero
		TipoOperacionDefault // Tipo de Operacion Default 
		MagnaConapesca // Clave de Magna Conapesca
		UtilizarFormatoResumidoDetallado // Utilizar Formato Resumido/Detallado en Facturas // Si;No // No
		QuitarDecimalesEnCapturaLecturaFinalLiq // Quitar Decimales en Lectura Final de Liquidaciones // Si;No // No
		DobleTicketTarjeta // Imprimir Doble Ticket de Tarjeta Magnetica // Si;No // No
		UtilizarReferenciaPaquetes // Utilizar Referencia de Paquetes en Facturas de Cupones // Si;No // No
		IncluirMermaComprasInventario // Incluir Merma como costo de las Compras de Pemex.  // Si;No // Si
		UtilizarReferenciaPaqFACP // Utilizar Referencia de Paquetes en Facturas de Prepago // Si;No // No
		CorteGlobalRefrescar // Turno de Corte Global a Refrescar en Punto de Venta // // 4
		AgruparTicketPorComb // Agrupar Folios de Tickets por Comb. en Facturas // Si;No // No
		ManejaJefeTurno // Manejar Jefes de Turno en Liquidaciones y Punto de Venta // Si;No // No
		ImprimeCodTarjeta // Imprimir Nùmero de Tarjeta en Tickets PVG // Si;No // Si
		DecPresCPMX // Numero de Decimales a manejar en precios CPMX // // 6
		ValidarIslas // Validar Liquidaciones de Islas para Cierre de Turno // Si;No // No
		TargetURLFACELE // TargetURL de Facturación Electrónica // // http:/localhost:8098/BIN
		TargetURLFACELE2 // TargetURL de Facturación Electrónica 2 // // http:/localhost:8097/BIN
		PreciosPorEstacion // Manejar Precios de Productos por Estación // Si;No // No
		SelecionaFormato // Mostrar Pantalla de Seleccion de Formato de Impresión // Si;No // No
		MinFoliosFACELE // Cantidad Mínima de Folios Electronicos disponibles // // 10
		TargetURLMaster // TargetURL de Servidor Master // // http:/localhost:8099/BIN
		ModoEnvioEmailFACELE // Modo de Envío E-mail FACELE [AlGenerar/CerrarTurno/NoEnviar] // AlGenerar;CerrarTurno;NoEnviar // AlGenerar
		LongitudCSEG // Cantidad caracteres en Código de Seguridad // // 16
		EnviarMailValesPendientes // Enviar email de vales pendientes de Facturar // Si;No // No
		NumeroDiasRevisionVales // Numero de Dias para revision de vales endientes en email // // 7
		RestringirSalidaAlmacenLiq // Restringir Salidas de Almacén // Si;No // No
		ProteccionCodigosTarjetas // Activa Proteccion de Códigos Tarjetas i-Gas // Si;No // No
		MiliSegundosProteccion // Milisegundos de Proteccion // // 30
		ConCargoACredito // Activar 'Con Cargo a:' Facturas de Crédito // Si;No // No
		MuestraCodigoTarjetaPVG // Mostrar Codigo Tarjeta PVG // Si;No // No
		ValidarDocsVendicosCXC // Validar Documentos Vencidos de CXC // Si;No // No
		ModoFacturaGlobal // Modo Factura Global [Dia/Mes] // Dia;Mes // Dia
		FormaPagoFACELE_FACR // Forma pago FACELE Default Facturas de Crédito // // PAGO EN UNA SOLA EXHIBICIÓN
		ValidarCreditoPreAuto // Validar Crédito en PreAutorizaciones // Si;No // Si
		MaximoDcto // Porcentaje Maximo de Descuento en Notas de Bonificación // // 100
		RestringirLiquidacionesM // Restringir Liquidaciones Combustibles y Aceites // Si;No // ".$RestringirLiquidacionesM."
		EnvioFactKiosco // Enviar Facturas Creadas en el Kiosco al Cerrar Turno // Si;No // No
		NoClienteRes // Clave de Cliente para Resguardar Efectivo
		ResguardoEfectivo // Activar Resguardo de Efectivo // Si;No // No
		FctAutValesCliente // Activar Factura Automatica Vales de nivel Cliente // Si;No // No
		PermitirCerrarTurno // Permitir Cerrar Turno con Inconsistencias //Si;No // Si
		ReintentosFacele // Número de Reintentos al Generar Factura Electrónica // // 2
		CorreoDirectivo // Correo Electrónico para Enviar Reporte Directivo // //
		FctGlobalDiaCont // Activar Factura Global Diaria Solo Contado // Si;No // No
		RestringirVtasAceiCred // Restringir Ventas de Aceites a Crédito // Si;No // No
		ValesPendientesDesglo // Enviar Desglosado los Vales Pendientes de Facturar // Si;No // No
		UnidadProductosVarios // Unidad para productos varios // //
		SiValesPendientesDesglo // Enviar Desglosado los Vales Pendientes de Facturar // Si;No // No
		ClientesRetenciones //Clientes que Manejan Retenciones // //
		RestringirReabrirTurnosAnt // Restringir Reabrir Turnos Anteriores en Facturación // Si;No // No
		OcultarTipoPagoFct // Ocultar Tipo de Operación en Facturas // Si;No // No
		CalcularIEPS // Calcular IEPS // Si;No // Si
		RestringirCancelarFct // Restringir Cancelar Facturas con Fecha Distinta a la de su Emisión // Si;No // No
		ReportesEstacionActiva // Permite Mostrar Reportes Únicamente para la Estación Activa // Si;No // No
		RestringirFctDirectas // Restringir Realizar Facturas Directas // Si;No // No
		ReplicarPassTag // Replicar el Contraseña Despachador en Tag // Si;No // No
		IncluirGpoFctTicket // Incluir Gpo de Fct en Ticket de Venta // Si;No // No
		MaximoImporteVentaTarjetaPVG // Máximo Importe de Ventas con Tarjeta PVG // // 9999.99
		ExcluirPagosFctGlobalDiaria // Excluir Tipos Pagos Fct Global Diaria // Si;No // No
		TiposPagosFctGloablDia // Tipos Pagos Excluir Fct Global Diaria // //
		SelecCorreoAlEnviarFacElec // Seleccionar Correo al Enviar Factura Electrónica // Si;No // No
		LiqTurnosAuto // Activar Turnos Automaticos en Liquidaciones // Si;No // No
		CancelarCupones// Poner en Estatus Cancelado los Cupones al Cancelar la Fct // Si;No // No
		CteTICteTIOri // Cliente Tarjeta Inteligente ; Cliente tarjeta inteligente original ////
		TPagoTI // Tipo de Pago para clasificar movimientos de tarjeta inteligente ////
		BloquearLiqEnTurnoReabierto // Bloquear Liquidaciones en Turnos Reabiertos // Si;No // No
		ImprimeFacPdf // Imprimir Facturas desde PDF // Si;No // No
		ValidaCXCenPVG // Valida cargos vencidos en Punto de Venta // Si;No // No
		SubclaveReq // Subclave requerida en facturación // Si;No // No
		FechaInicioFactAnticipada // Fecha de Inicio de Facturas de Venta Anticipada ////
		ExportarXMLFct // Exportar XML de Facturas Después de Póliza // Si;No // No
		ReplicarCtaCntCte // Replicar cuenta contable de vales a catálogo de clientes // Si;No // No
		AgrupaAceitesFacMes // Agrupar aceites en factura mensual // Si;No // No
		TickVolFacMes // Sólo considerar tickets posteriores a la factura global // Si;No // No
		TPagoPromoKiosco // No. de tipo de pago de promoción de kiosco // //
		ImprimirRendVehi // Imprimir Rendimiento por Vehículo en boucher // Si;No // No
		ModoRendVehi // Modo cálculo rend. 1-Lt. Carga Anterior, 2-Lt. Carga Actual // 1;2 // 1 
		AdendaObserv // Utilizar observaciones como adenda en facturas de contado // Si;No // No
		PermitirAlfanumEnCodigoTarjetas // Permitir caracteres alfanumérico en código de tarjetas // Si;No // No
		ActualizarFechaTrabajoAutom // Actualizar fecha de trabajo automático // Si;No // No
		ConsiderarTodosLosTickets // Considerar todos los tickets // Si;No // No
		ValidarCreditoClienteEnVales // Validar el crédito de clientes en vales // Si;No // No
		GenerarSalidaAlmacenIslas // Generar salida de almacén a aceites por islas // Si;No // No  
		PolizaGlobal // Calcular póliza global de facturación //Si;No // No
		ComplementoTAREnFacturas // Complemento TAR en facturas //Si;No // No
		IgasRedes // Activar Igas Redes //Si;No // No
		MasterNET // Activar servicios de Master NET // Si;No // No
		ServMasterNet // Servidor y puerto de Master NET // // 127.0.0.1:808
		MostrarActivacionFolios // Mostrar activación de folios al cerrar turno //Si;No // Si
		LigarPolizasCXCconLIQ // Ligar pólizas de Cobranza con Liquidaciones // Si; No // No
		ProductoDescuento // Clave de producto para descuentos // //
		SerieCupDescuento // Serie de cupones para descuentos // //
		FctGlobalEst // Factura global por todas las estaciones //Si;No // No
		FactGlobalALaFecha // Generar factura global por rango en el mes //Si;No // No
		PromocionesKiosco // Promociones kiosco [Rango/Detallado] // Rango;Detallado // Rango
		ImpTicketsKio // Imprimir tickets en kiosco (Si/No/Derechos) // Si;No;Derechos // Si
		TipoDeTicket // Tipo de ticket (Todos/Combustibles/Aceites) // Todos;Combustibles;Aceites // Todos
		ExportarTipoPago // Exportar tipos de pago a I-Gas Cliente // Si;No // No
		DiasResumenLiq // Días para mostrar resumen de liquidaciones
		CierreDíaLiqManual // Cierre de día de liquidacicones manual // Si;No // No
		PermiteConfigurarIEPSNBON // Permite configurar IEPS en nota de crédito // Si;No // No
		FoliosVolFactGlobal // Mostrar folios volumétricos en factura global // Si;No // No 
		IslaVirtual // Isla virtual de liquidaciones
		ValidaUUIDEnNcre // Valida UUID en Notas de Crédito // Si;No // No
		ValidarNCreAlCerrarTurno // Verificar notas sin refacturar al cerrar turno // Si;No // No
		EtiFoliosTransFac // Etiqueta folios de transacciones en facturas
		NoConceptosEnFactGlobal // Número máximo de conceptos en Factura Global // // 1000
		MaximoModImporteFolioVol // Máximo importe a modificar por concepto en Factura Global // //100
		ClaveClienteDefaultFacturaGlobal // Clave de cliente default para Factura Global // //
		CostoProdCpmx // Afectar costo de productos con mermas en compras Pemex // Si;No // No
		FechaActivarModoFacVol // Fecha para activar Modo de facturación volumétrico";

		$variables ="PosicionCliente = 1
		LongitudCliente = 6
		PosicionVehiculo = 7
		LongitudVehiculo = 2
		ImpresoraTicket = \\Recepcion\Panasonic
		IvaCombustible = 16
		DiasCuponesVenc = 365
		DiasFacturaContado = 1
		ConceptoFactCupones = 
		ConceptoFactCredito = 
		CombustibleDefFacc = 1
		MaximoTurnosLiq = 4
		AuxiliarValesDefault = Supervisor, Costos
		AuxiliarCuponesDefault = Supervisor, Costos
		PolizaLiqDia = Si
		CapturarDevoluciones = ".$CapturarDevoluciones."
		ValidarValesyCupones = Si
		PermitirMovimientosAnteriores = Si
		ImprimirCuponesFact = Si
		ClienteSagarpa = 
		CargoSagarpaContado = Si
		DieselSagarpa = 
		UtilizarReferencia = Si
		DespachadorVales = No
		IslaVales = Si
		ImprimirPagareFaltantes = Si
		AuxiliarLiq = 2
		CostoCombustiblesAlma = Si
		CostoProductosAlma = Si
		DigitosCupon = 6
		FolioFacturaUnico = No
		ValidaSaldoTarjetaCredito = Si
		ValidaCuponesImpresos = Si
		CorteTurnoEnLinea = No
		SerieEnBarrasCupones = Si
		FolioVolumetricoVales = Si
		ClaveProveedorPemex = 1
		SerieCompraPemex = PX
		SubsidioInbursa = No
		ClienteInbursa = 
		CargoInbursaContado = Si
		TipoMovCargoVales = VC
		MaxFoliosVolumetricos = 100
		AcumularOCCPemex = No
		SerieOtrosCostos = OG
		EtiquetaFoliosVolumetricos = Folios:
		RestringirLiquidaciones = ".$RestringirLiquidaciones."
		ConceptoDeposito = 
		TipoOperacionDefault = 
		MagnaConapesca = 
		UtilizarFormatoResumidoDetallado = No
		QuitarDecimalesEnCapturaLecturaFinalLiq = No
		DobleTicketTarjeta = No
		UtilizarReferenciaPaquetes = No
		IncluirMermaComprasInventario = Si
		UtilizarReferenciaPaqFACP = No
		CorteGlobalRefrescar = 4
		AgruparTicketPorComb = No
		ManejaJefeTurno = No
		ImprimeCodTarjeta = Si
		DecPresCPMX = 6
		ValidarIslas = Si
		TargetURLFACELE = http://volumetrico:8097/bin
		TargetURLFACELE2 = http:/localhost:8097/BIN
		PreciosPorEstacion = Si
		SelecionaFormato = No
		MinFoliosFACELE = 10
		TargetURLMaster = http://Volumetrico:8099/BIN
		ModoEnvioEmailFACELE = AlGenerar
		LongitudCSEG = 16
		EnviarMailValesPendientes = No
		NumeroDiasRevisionVales = 7
		RestringirSalidaAlmacenLiq = Si
		ProteccionCodigosTarjetas = No
		MiliSegundosProteccion = 30
		ConCargoACredito = No
		MuestraCodigoTarjetaPVG = No
		ValidarDocsVendicosCXC = No
		ModoFacturaGlobal = Dia
		FormaPagoFACELE_FACR = PAGO EN UNA SOLA EXHIBICIÓN
		ValidarCreditoPreAuto = Si
		MaximoDcto = 100
		RestringirLiquidacionesM = ".$RestringirLiquidacionesM."
		EnvioFactKiosco = No
		NoClienteRes = 
		ResguardoEfectivo = No
		FctAutValesCliente = No
		PermitirCerrarTurno = Si
		ReintentosFacele = 2
		CorreoDirectivo = 
		FctGlobalDiaCont = No
		RestringirVtasAceiCred = No
		ValesPendientesDesglo = No
		UnidadProductosVarios = No Aplica
		SiValesPendientesDesglo = No
		ClientesRetenciones = 
		RestringirReabrirTurnosAnt = No
		OcultarTipoPagoFct = No
		CalcularIEPS = Si
		RestringirCancelarFct = No
		ReportesEstacionActiva = No
		RestringirFctDirectas = No
		ReplicarPassTag = No
		IncluirGpoFctTicket = No
		MaximoImporteVentaTarjetaPVG = 9999.99
		ExcluirPagosFctGlobalDiaria = No
		TiposPagosFctGloablDia = 8;10;11;17;14;32;37;38;41;40;42;20;21;22;26
		SelecCorreoAlEnviarFacElec = No
		LiqTurnosAuto = No
		CancelarCupones = Si
		CteTICteTIOri = 
		TPagoTI = 
		BloquearLiqEnTurnoReabierto = No
		ImprimeFacPdf = No
		ValidaCXCenPVG = No
		SubclaveReq = No
		FechaInicioFactAnticipada = 
		ExportarXMLFct = No
		ReplicarCtaCntCte = No
		AgrupaAceitesFacMes = No
		TickVolFacMes = No
		TPagoPromoKiosco = 
		ImprimirRendVehi = No
		ModoRendVehi = 2
		AdendaObserv = No
		PermitirAlfanumEnCodigoTarjetas = No
		ActualizarFechaTrabajoAutom = No
		ConsiderarTodosLosTickets = No
		ValidarCreditoClienteEnVales = No
		GenerarSalidaAlmacenIslas = No
		PolizaGlobal = No
		ComplementoTAREnFacturas = No
		IgasRedes = No
		MasterNET = No
		ServMasterNet = 127.0.0.1:808
		MostrarActivacionFolios = No
		LigarPolizasCXCconLIQ = No
		ProductoDescuento = 
		SerieCupDescuento = 
		FctGlobalEst = No
		FactGlobalALaFecha = No
		PromocionesKiosco = Rango
		ImpTicketsKio = Si
		TipoDeTicket = Todos
		ExportarTipoPago = No
		DiasResumenLiq = 8
		CierreDíaLiqManual = Si
		PermiteConfigurarIEPSNBON = No
		FoliosVolFactGlobal = Si
		IslaVirtual = 
		ValidaUUIDEnNcre = No
		ValidarNCreAlCerrarTurno = No
		EtiFoliosTransFac = 
		NoConceptosEnFactGlobal = 1000
		MaximoModImporteFolioVol = 100
		ClaveClienteDefaultFacturaGlobal = 
		CostoProdCpmx = No
		FechaActivarModoFacVol = 01/01/2022";

		

		// $blob_variables = ibase_blob_create($obj->conectarADM());
		// $add_variables=ibase_blob_add($blob_variables, $variables);
		// // $blobid_variables = ibase_blob_close($blh);

		// $blob_listvar = ibase_blob_create($obj->conectarADM());
		// $add_listvar= ibase_blob_add($blob_listvar, $variables);
		// $blob = ibase_blob_import($obj->conectarADM(), $add_listvar);
		
		// $sql = "INSERT INTO blobtable(blobfield) VALUES (?)";
		$clavesis ="GAS";
		$nombre= "i-Gas Administración";
		$version = "3.1";
		$claveautor = "RIRIT363";
		$fechainicial = "01/01/2001 12:00:00 a.m.";
		$fechaenlace = "01/01/2001 12:00:00 a.m.";

		$revision ="1.0001";
		$tabla ="HJ";
		$especiales ="ATMC // Autorización para Realizar Trapasos de Mov. entre Clientes
		ATFL // Autorización Especial para Transacciones fuera de Linea.";
		$usuarios = 12;
		$licenciatemporal = "No";

		$listavar = utf8_decode($listavar);
		$variables = utf8_decode($variables);
		$update_listavar =$this->agregar_blob($obj->conectarADM(),$listavar,"LISTAVAR");
		$update_variables =  $this->agregar_blob($obj->conectarADM(),$variables,"VARIABLES");

		if ($update_listavar > 0 && $update_variables > 0 ) {
			session_start();
			$this->monitoreo_movimientos($objc->conectar(),"HERRAMIENTAS",$opcion,$_SESSION["user"],"Bloquear Liquidaciones", "Existoso");
			$array = array("respuesta" => "bien");
			echo json_encode($array);
		}else{
			session_start();
			$this->monitoreo_movimientos($objc->conectar(),"HERRAMIENTAS",$opcion,$_SESSION["user"],"Bloquear Liquidaciones", "Error");
			$array = array("respuesta" => "error");
			echo json_encode($array);
		}




	}


	public function agregar_blob($conexion,$datos,$campo)
	{

		$clavesis ="GAS";
		$blob_new = ibase_blob_create($conexion);
		ibase_blob_add($blob_new, $datos);
		$blobid = ibase_blob_close($blob_new);

		$sql = "UPDATE DGENSIST  SET  ".$campo." = ? WHERE CLAVESIS = '$clavesis'";
		return $sth = ibase_query($conexion, $sql, $blobid);
	}


	public function monitoreo_movimientos($conexion,$modulo,$movimiento, $usuario,$submodulo, $conclusion)
	{

		$id = $this->registros($conexion, "MOVIMIENTOS");
		$id =$id+1;
		$ahora =date('d.m.Y g:ia');
		$fecha  = date('d.m.y H:i:s');
		(String)$fecha;
		$movimiento = "INSERT INTO MOVIMIENTOS (ID,USUARIO,FECHA,MODULO,MOVIMIENTO, SUBMODULO,CONCLUSION) VALUES ('$id','$usuario', '$fecha', '$modulo', '$movimiento','$submodulo', '$conclusion')";
		ibase_query($conexion,$movimiento);

	}



	public function registros($conexion,$tabla)
	{
		$cont = "SELECT COUNT(*) AS REGISTROS FROM ".$tabla."";
		$exe_cont = ibase_query($conexion,$cont);
		$cantidad  = ibase_fetch_assoc($exe_cont);
		return $cantidad["REGISTROS"];
	}



	//------    CONVERTIR NUMEROS A LETRAS         ---------------
//------    Máxima cifra soportada: 18 dígitos con 2 decimales
//------    999,999,999,999,999,999.99
// NOVECIENTOS NOVENTA Y NUEVE MIL NOVECIENTOS NOVENTA Y NUEVE BILLONES
// NOVECIENTOS NOVENTA Y NUEVE MIL NOVECIENTOS NOVENTA Y NUEVE MILLONES
// NOVECIENTOS NOVENTA Y NUEVE MIL NOVECIENTOS NOVENTA Y NUEVE PESOS 99/100 M.N.
//------    Creada por:                        ---------------
//------             ULTIMINIO RAMOS GALÁN     ---------------
//------            uramos@gmail.com           ---------------
//------    10 de junio de 2009. México, D.F.  ---------------
//------    PHP Version 4.3.1 o mayores (aunque podría funcionar en versiones anteriores, tendrías que probar)
	function numtoletras($xcifra)
	{
		$xarray = array(0 => "Cero",
			1 => "UN", "DOS", "TRES", "CUATRO", "CINCO", "SEIS", "SIETE", "OCHO", "NUEVE",
			"DIEZ", "ONCE", "DOCE", "TRECE", "CATORCE", "QUINCE", "DIECISEIS", "DIECISIETE", "DIECIOCHO", "DIECINUEVE",
			"VEINTI", 30 => "TREINTA", 40 => "CUARENTA", 50 => "CINCUENTA", 60 => "SESENTA", 70 => "SETENTA", 80 => "OCHENTA", 90 => "NOVENTA",
			100 => "CIENTO", 200 => "DOSCIENTOS", 300 => "TRESCIENTOS", 400 => "CUATROCIENTOS", 500 => "QUINIENTOS", 600 => "SEISCIENTOS", 700 => "SETECIENTOS", 800 => "OCHOCIENTOS", 900 => "NOVECIENTOS"
		);
//
		$xcifra = trim($xcifra);
		$xlength = strlen($xcifra);
		$xpos_punto = strpos($xcifra, ".");
		$xaux_int = $xcifra;
		$xdecimales = "00";
		if (!($xpos_punto === false)) {
			if ($xpos_punto == 0) {
				$xcifra = "0" . $xcifra;
				$xpos_punto = strpos($xcifra, ".");
			}
        $xaux_int = substr($xcifra, 0, $xpos_punto); // obtengo el entero de la cifra a covertir
        $xdecimales = substr($xcifra . "00", $xpos_punto + 1, 2); // obtengo los valores decimales
    }

    $XAUX = str_pad($xaux_int, 18, " ", STR_PAD_LEFT); // ajusto la longitud de la cifra, para que sea divisible por centenas de miles (grupos de 6)
    $xcadena = "";
    for ($xz = 0; $xz < 3; $xz++) {
    	$xaux = substr($XAUX, $xz * 6, 6);
    	$xi = 0;
        $xlimite = 6; // inicializo el contador de centenas xi y establezco el límite a 6 dígitos en la parte entera
        $xexit = true; // bandera para controlar el ciclo del While
        while ($xexit) {
            if ($xi == $xlimite) { // si ya llegó al límite máximo de enteros
                break; // termina el ciclo
            }

            $x3digitos = ($xlimite - $xi) * -1; // comienzo con los tres primeros digitos de la cifra, comenzando por la izquierda
            $xaux = substr($xaux, $x3digitos, abs($x3digitos)); // obtengo la centena (los tres dígitos)
            for ($xy = 1; $xy < 4; $xy++) { // ciclo para revisar centenas, decenas y unidades, en ese orden
            	switch ($xy) {
                    case 1: // checa las centenas
                        if (substr($xaux, 0, 3) < 100) { // si el grupo de tres dígitos es menor a una centena ( < 99) no hace nada y pasa a revisar las decenas

                        } else {
                        	$key = (int) substr($xaux, 0, 3);
                            if (TRUE === array_key_exists($key, $xarray)){  // busco si la centena es número redondo (100, 200, 300, 400, etc..)
                            	$xseek = $xarray[$key];
                                $xsub = $this->subfijo($xaux); // devuelve el subfijo correspondiente (Millón, Millones, Mil o nada)
                                if (substr($xaux, 0, 3) == 100)
                                	$xcadena = " " . $xcadena . " CIEN " . $xsub;
                                else
                                	$xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                $xy = 3; // la centena fue redonda, entonces termino el ciclo del for y ya no reviso decenas ni unidades
                            }
                            else { // entra aquí si la centena no fue numero redondo (101, 253, 120, 980, etc.)
                            	$key = (int) substr($xaux, 0, 1) * 100;
                                $xseek = $xarray[$key]; // toma el primer caracter de la centena y lo multiplica por cien y lo busca en el arreglo (para que busque 100,200,300, etc)
                                $xcadena = " " . $xcadena . " " . $xseek;
                            } // ENDIF ($xseek)
                        } // ENDIF (substr($xaux, 0, 3) < 100)
                        break;
                    case 2: // checa las decenas (con la misma lógica que las centenas)
                    if (substr($xaux, 1, 2) < 10) {

                    } else {
                    	$key = (int) substr($xaux, 1, 2);
                    	if (TRUE === array_key_exists($key, $xarray)) {
                    		$xseek = $xarray[$key];
                    		$xsub = $this->subfijo($xaux);
                    		if (substr($xaux, 1, 2) == 20)
                    			$xcadena = " " . $xcadena . " VEINTE " . $xsub;
                    		else
                    			$xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                    		$xy = 3;
                    	}
                    	else {
                    		$key = (int) substr($xaux, 1, 1) * 10;
                    		$xseek = $xarray[$key];
                    		if (20 == substr($xaux, 1, 1) * 10)
                    			$xcadena = " " . $xcadena . " " . $xseek;
                    		else
                    			$xcadena = " " . $xcadena . " " . $xseek . " Y ";
                            } // ENDIF ($xseek)
                        } // ENDIF (substr($xaux, 1, 2) < 10)
                        break;
                    case 3: // checa las unidades
                        if (substr($xaux, 2, 1) < 1) { // si la unidad es cero, ya no hace nada

                        } else {
                        	$key = (int) substr($xaux, 2, 1);
                            $xseek = $xarray[$key]; // obtengo directamente el valor de la unidad (del uno al nueve)
                            $xsub = $this->subfijo($xaux);
                            $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                        } // ENDIF (substr($xaux, 2, 1) < 1)
                        break;
                } // END SWITCH
            } // END FOR
            $xi = $xi + 3;
        } // ENDDO

        if (substr(trim($xcadena), -5, 5) == "ILLON") // si la cadena obtenida termina en MILLON o BILLON, entonces le agrega al final la conjuncion DE
        $xcadena.= " DE";

        if (substr(trim($xcadena), -7, 7) == "ILLONES") // si la cadena obtenida en MILLONES o BILLONES, entoncea le agrega al final la conjuncion DE
        $xcadena.= " DE";

        // ----------- esta línea la puedes cambiar de acuerdo a tus necesidades o a tu país -------
        if (trim($xaux) != "") {
        	switch ($xz) {
        		case 0:
        		if (trim(substr($XAUX, $xz * 6, 6)) == "1")
        			$xcadena.= "UN BILLON ";
        		else
        			$xcadena.= " BILLONES ";
        		break;
        		case 1:
        		if (trim(substr($XAUX, $xz * 6, 6)) == "1")
        			$xcadena.= "UN MILLON ";
        		else
        			$xcadena.= " MILLONES ";
        		break;
        		case 2:
        		if ($xcifra < 1) {
        			$xcadena = "CERO PESOS $xdecimales/100 M.N.";
        		}
        		if ($xcifra >= 1 && $xcifra < 2) {
        			$xcadena = "UN PESO $xdecimales/100 M.N. ";
        		}
        		if ($xcifra >= 2) {
                        $xcadena.= " PESOS $xdecimales/100 M.N. "; //
                    }
                    break;
            } // endswitch ($xz)
        } // ENDIF (trim($xaux) != "")
        // ------------------      en este caso, para México se usa esta leyenda     ----------------
        $xcadena = str_replace("VEINTI ", "VEINTI", $xcadena); // quito el espacio para el VEINTI, para que quede: VEINTICUATRO, VEINTIUN, VEINTIDOS, etc
        $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
        $xcadena = str_replace("UN UN", "UN", $xcadena); // quito la duplicidad
        $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
        $xcadena = str_replace("BILLON DE MILLONES", "BILLON DE", $xcadena); // corrigo la leyenda
        $xcadena = str_replace("BILLONES DE MILLONES", "BILLONES DE", $xcadena); // corrigo la leyenda
        $xcadena = str_replace("DE UN", "UN", $xcadena); // corrigo la leyenda
    } // ENDFOR ($xz)
    return trim($xcadena);
}

// END FUNCTION

function subfijo($xx)
{ // esta función regresa un subfijo para la cifra
	$xx = trim($xx);
	$xstrlen = strlen($xx);
	if ($xstrlen == 1 || $xstrlen == 2 || $xstrlen == 3)
		$xsub = "";
    //
	if ($xstrlen == 4 || $xstrlen == 5 || $xstrlen == 6)
		$xsub = "MIL";
    //
	return $xsub;
}


}






?>