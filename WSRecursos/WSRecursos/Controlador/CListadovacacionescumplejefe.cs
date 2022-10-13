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
    public class CListadovacacionescumplejefe
    {
        public List<EListadovacacionescumplejefe> Listadovacacionescumplejefe(SqlConnection con, String dni, String finicio, String ffin)
        {
            List<EListadovacacionescumplejefe> lEListadovacacionescumplejefe = null;
            SqlCommand cmd = new SqlCommand("ASP_CONTROL_VACACIONES_CUMPLE_JEFEAREA", con);
            cmd.CommandType = CommandType.StoredProcedure;

            cmd.Parameters.AddWithValue("@dni", SqlDbType.VarChar).Value = dni;
            cmd.Parameters.AddWithValue("@finicio", SqlDbType.VarChar).Value = finicio;
            cmd.Parameters.AddWithValue("@ffin", SqlDbType.VarChar).Value = ffin;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEListadovacacionescumplejefe = new List<EListadovacacionescumplejefe>();

                EListadovacacionescumplejefe obEListadovacacionescumplejefe = null;
                while (drd.Read())
                {
                    obEListadovacacionescumplejefe = new EListadovacacionescumplejefe();
                    obEListadovacacionescumplejefe.i_id = drd["i_id"].ToString();
                    obEListadovacacionescumplejefe.v_dni = drd["v_dni"].ToString();
                    obEListadovacacionescumplejefe.v_nombre = drd["v_nombre"].ToString();
                    obEListadovacacionescumplejefe.v_tipo = drd["v_tipo"].ToString();
                    obEListadovacacionescumplejefe.v_color_tipo = drd["v_color_tipo"].ToString();
                    obEListadovacacionescumplejefe.d_finicio = drd["d_finicio"].ToString();
                    obEListadovacacionescumplejefe.d_ffin = drd["d_ffin"].ToString();
                    obEListadovacacionescumplejefe.d_registro = drd["d_registro"].ToString();
                    obEListadovacacionescumplejefe.d_aprobacion = drd["d_aprobacion"].ToString();
                    obEListadovacacionescumplejefe.i_estado = Convert.ToInt32(drd["i_estado"].ToString());
                    obEListadovacacionescumplejefe.v_estado = drd["v_estado"].ToString();
                    obEListadovacacionescumplejefe.v_style_fechaproceso = drd["v_style_fechaproceso"].ToString();
                    obEListadovacacionescumplejefe.v_estado_color = drd["v_estado_color"].ToString();
                    obEListadovacacionescumplejefe.v_aprobar = drd["v_aprobar"].ToString();
                    lEListadovacacionescumplejefe.Add(obEListadovacacionescumplejefe);
                }
                drd.Close();
            }

            return (lEListadovacacionescumplejefe);
        }
    }
}