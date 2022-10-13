using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.Collections.Specialized;
using System.Linq;
using System.Web;
using System.Data;
using System.Data.SqlClient;
using WSRecursos.Entity;

namespace WSRecursos.Controller
{
    public class CListaReportePagoVacaciones
    {
        public List<EListaReportePagoVacaciones> ListaReportePagoVacaciones(SqlConnection con, Int32 mes, Int32 anhio)
        {
            List<EListaReportePagoVacaciones> lEListaReportePagoVacaciones = null;
            SqlCommand cmd = new SqlCommand("ASP_REPORTE_PAGOVACACIONES", con);
            cmd.CommandType = CommandType.StoredProcedure;

            cmd.Parameters.AddWithValue("@mes", SqlDbType.Int).Value = mes;
            cmd.Parameters.AddWithValue("@anhio", SqlDbType.Int).Value = anhio;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEListaReportePagoVacaciones = new List<EListaReportePagoVacaciones>();

                EListaReportePagoVacaciones obEListaReportePagoVacaciones = null;
                while (drd.Read())
                {
                    obEListaReportePagoVacaciones = new EListaReportePagoVacaciones();
                    obEListaReportePagoVacaciones.row = Convert.ToInt32(drd["row"].ToString());
                    obEListaReportePagoVacaciones.v_periodo = drd["v_periodo"].ToString();
                    obEListaReportePagoVacaciones.v_dni = drd["v_dni"].ToString();
                    obEListaReportePagoVacaciones.v_nombres = drd["v_nombres"].ToString();
                    obEListaReportePagoVacaciones.v_area = drd["v_area"].ToString();
                    obEListaReportePagoVacaciones.v_cargo = drd["v_cargo"].ToString();
                    obEListaReportePagoVacaciones.v_zona = drd["v_zona"].ToString();
                    obEListaReportePagoVacaciones.v_banco = drd["v_banco"].ToString();
                    obEListaReportePagoVacaciones.v_cta = drd["v_cta"].ToString();
                    obEListaReportePagoVacaciones.v_afp = drd["v_afp"].ToString();
                    obEListaReportePagoVacaciones.f_basico = Convert.ToDouble(drd["f_basico"].ToString());
                    obEListaReportePagoVacaciones.d_finicio = drd["d_finicio"].ToString();
                    obEListaReportePagoVacaciones.d_ffin = drd["d_ffin"].ToString();
                    obEListaReportePagoVacaciones.v_total = Convert.ToInt32(drd["v_total"].ToString());
                    obEListaReportePagoVacaciones.f_vacaciones = Convert.ToDouble(drd["f_vacaciones"].ToString());
                    obEListaReportePagoVacaciones.f_ingresos = Convert.ToDouble(drd["f_ingresos"].ToString());
                    obEListaReportePagoVacaciones.f_sneto = Convert.ToDouble(drd["f_sneto"].ToString());
                    lEListaReportePagoVacaciones.Add(obEListaReportePagoVacaciones);
                }
                drd.Close();
            }

            return (lEListaReportePagoVacaciones);
        }
    }
}