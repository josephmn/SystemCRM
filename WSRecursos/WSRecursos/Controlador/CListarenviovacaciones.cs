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
    public class CListarenviovacaciones
    {
        public List<EListarenviovacaciones> Listarenviovacaciones(SqlConnection con, Int32 mes, Int32 anhio)
        {
            List<EListarenviovacaciones> lEListarenviovacaciones = null;
            SqlCommand cmd = new SqlCommand("ASP_LISTAR_ENVIOVACACIONES", con);
            cmd.CommandType = CommandType.StoredProcedure;

            cmd.Parameters.AddWithValue("@mes", SqlDbType.Int).Value = mes;
            cmd.Parameters.AddWithValue("@anhio", SqlDbType.Int).Value = anhio;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEListarenviovacaciones = new List<EListarenviovacaciones>();

                EListarenviovacaciones obEListarenviovacaciones = null;
                while (drd.Read())
                {
                    obEListarenviovacaciones = new EListarenviovacaciones();
                    obEListarenviovacaciones.i_prog = Convert.ToInt32(drd["i_prog"].ToString());
                    obEListarenviovacaciones.i_vac = Convert.ToInt32(drd["i_vac"].ToString());
                    obEListarenviovacaciones.v_dni = drd["v_dni"].ToString();
                    obEListarenviovacaciones.v_nombres = drd["v_nombres"].ToString();
                    obEListarenviovacaciones.v_nommes = drd["v_nommes"].ToString();
                    obEListarenviovacaciones.i_anhio = Convert.ToInt32(drd["i_anhio"].ToString());
                    obEListarenviovacaciones.d_finicio = drd["d_finicio"].ToString();
                    obEListarenviovacaciones.d_ffin = drd["d_ffin"].ToString();
                    obEListarenviovacaciones.v_total = Convert.ToInt32(drd["v_total"].ToString());
                    obEListarenviovacaciones.v_tipo = drd["v_tipo"].ToString();
                    obEListarenviovacaciones.v_color_tipo = drd["v_color_tipo"].ToString();
                    obEListarenviovacaciones.v_estado = drd["v_estado"].ToString();
                    obEListarenviovacaciones.d_aprobado = drd["d_aprobado"].ToString();
                    obEListarenviovacaciones.d_corte = drd["d_corte"].ToString();
                    obEListarenviovacaciones.i_generado = Convert.ToInt32(drd["i_generado"].ToString());
                    obEListarenviovacaciones.i_confirmado = Convert.ToInt32(drd["i_confirmado"].ToString());
                    obEListarenviovacaciones.v_generado = drd["v_generado"].ToString();
                    obEListarenviovacaciones.v_color = drd["v_color"].ToString();
                    lEListarenviovacaciones.Add(obEListarenviovacaciones);
                }
                drd.Close();
            }

            return (lEListarenviovacaciones);
        }
    }
}