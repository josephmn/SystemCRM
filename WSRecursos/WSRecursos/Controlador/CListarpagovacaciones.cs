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
    public class CListarpagovacaciones
    {
        public List<EListarpagovacaciones> Listarpagovacaciones(SqlConnection con, Int32 post, Int32 mes, Int32 anhio, String fecha)
        {
            List<EListarpagovacaciones> lEListarpagovacaciones = null;
            SqlCommand cmd = new SqlCommand("ASP_LISTAR_PAGOVACACIONES", con);
            cmd.CommandType = CommandType.StoredProcedure;

            cmd.Parameters.AddWithValue("@post", SqlDbType.Int).Value = post;
            cmd.Parameters.AddWithValue("@mes", SqlDbType.Int).Value = mes;
            cmd.Parameters.AddWithValue("@anhio", SqlDbType.Int).Value = anhio;
            cmd.Parameters.AddWithValue("@fecha", SqlDbType.VarChar).Value = fecha;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEListarpagovacaciones = new List<EListarpagovacaciones>();

                EListarpagovacaciones obEListarpagovacaciones = null;
                while (drd.Read())
                {
                    obEListarpagovacaciones = new EListarpagovacaciones();
                    obEListarpagovacaciones.i_prog = Convert.ToInt32(drd["i_prog"].ToString());
                    obEListarpagovacaciones.i_vac = Convert.ToInt32(drd["i_vac"].ToString());
                    obEListarpagovacaciones.v_dni = drd["v_dni"].ToString();
                    obEListarpagovacaciones.v_nombres = drd["v_nombres"].ToString();
                    obEListarpagovacaciones.v_nommes = drd["v_nommes"].ToString();
                    obEListarpagovacaciones.i_anhio = Convert.ToInt32(drd["i_anhio"].ToString());
                    obEListarpagovacaciones.d_finicio = drd["d_finicio"].ToString();
                    obEListarpagovacaciones.d_ffin = drd["d_ffin"].ToString();
                    obEListarpagovacaciones.v_total = Convert.ToInt32(drd["v_total"].ToString());
                    obEListarpagovacaciones.v_tipo = drd["v_tipo"].ToString();
                    obEListarpagovacaciones.v_color_tipo = drd["v_color_tipo"].ToString();
                    obEListarpagovacaciones.v_estado = drd["v_estado"].ToString();
                    obEListarpagovacaciones.d_aprobado = drd["d_aprobado"].ToString();
                    obEListarpagovacaciones.d_corte = drd["d_corte"].ToString();
                    lEListarpagovacaciones.Add(obEListarpagovacaciones);
                }
                drd.Close();
            }

            return (lEListarpagovacaciones);
        }
    }
}