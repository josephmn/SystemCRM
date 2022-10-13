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
    public class CListadocontrolvacacionesjefe
    {
        public List<EListadocontrolvacacionesjefe> Listar_Listadocontrolvacacionesjefe(SqlConnection con, String dni, String finicio, String ffin)
        {
            List<EListadocontrolvacacionesjefe> lEListadocontrolvacacionesjefe = null;
            SqlCommand cmd = new SqlCommand("ASP_CONTROL_VACACIONES_JEFEAREA", con);
            cmd.CommandType = CommandType.StoredProcedure;

            cmd.Parameters.AddWithValue("@dni", SqlDbType.VarChar).Value = dni;
            cmd.Parameters.AddWithValue("@finicio", SqlDbType.VarChar).Value = finicio;
            cmd.Parameters.AddWithValue("@ffin", SqlDbType.VarChar).Value = ffin;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEListadocontrolvacacionesjefe = new List<EListadocontrolvacacionesjefe>();

                EListadocontrolvacacionesjefe obEListadocontrolvacacionesjefe = null;
                while (drd.Read())
                {
                    obEListadocontrolvacacionesjefe = new EListadocontrolvacacionesjefe();
                    obEListadocontrolvacacionesjefe.i_id = drd["i_id"].ToString();
                    obEListadocontrolvacacionesjefe.v_dni = drd["v_dni"].ToString();
                    obEListadocontrolvacacionesjefe.v_nombre = drd["v_nombre"].ToString();
                    obEListadocontrolvacacionesjefe.v_tipo = drd["v_tipo"].ToString();
                    obEListadocontrolvacacionesjefe.v_color_tipo = drd["v_color_tipo"].ToString();
                    obEListadocontrolvacacionesjefe.d_finicio = drd["d_finicio"].ToString();
                    obEListadocontrolvacacionesjefe.d_ffin = drd["d_ffin"].ToString();
                    obEListadocontrolvacacionesjefe.d_registro = drd["d_registro"].ToString();
                    obEListadocontrolvacacionesjefe.d_aprobacion = drd["d_aprobacion"].ToString();
                    obEListadocontrolvacacionesjefe.i_estado = Convert.ToInt32(drd["i_estado"].ToString());
                    obEListadocontrolvacacionesjefe.v_estado = drd["v_estado"].ToString();
                    obEListadocontrolvacacionesjefe.v_style_fechaproceso = drd["v_style_fechaproceso"].ToString();
                    obEListadocontrolvacacionesjefe.v_estado_color = drd["v_estado_color"].ToString();
                    obEListadocontrolvacacionesjefe.v_aprobar = drd["v_aprobar"].ToString();
                    lEListadocontrolvacacionesjefe.Add(obEListadocontrolvacacionesjefe);
                }
                drd.Close();
            }

            return (lEListadocontrolvacacionesjefe);
        }
    }
}