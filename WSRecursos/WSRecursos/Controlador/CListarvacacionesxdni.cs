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
    public class CListarvacacionesxdni
    {
        public List<EListarvacacionesxdni> Listar_Listarvacacionesxdni(SqlConnection con, String dni)
        {
            List<EListarvacacionesxdni> lEListarvacacionesxdni = null;
            SqlCommand cmd = new SqlCommand("ASP_LISTAR_VACACIONES", con);
            cmd.CommandType = CommandType.StoredProcedure;

            cmd.Parameters.AddWithValue("@dni", SqlDbType.VarChar).Value = dni;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEListarvacacionesxdni = new List<EListarvacacionesxdni>();

                EListarvacacionesxdni obEListarvacacionesxdni = null;
                while (drd.Read())
                {
                    obEListarvacacionesxdni = new EListarvacacionesxdni();
                    obEListarvacacionesxdni.i_id = Convert.ToInt32(drd["i_id"].ToString());
                    obEListarvacacionesxdni.i_mes = Convert.ToInt32(drd["i_mes"].ToString());
                    obEListarvacacionesxdni.v_mes = drd["v_mes"].ToString();
                    obEListarvacacionesxdni.d_finicio = drd["d_finicio"].ToString();
                    obEListarvacacionesxdni.d_ffin = drd["d_ffin"].ToString();
                    obEListarvacacionesxdni.i_dias = Convert.ToInt32(drd["i_dias"].ToString());
                    obEListarvacacionesxdni.v_tipo = drd["v_tipo"].ToString();
                    obEListarvacacionesxdni.v_color_tipo = drd["v_color_tipo"].ToString();
                    obEListarvacacionesxdni.i_estado = Convert.ToInt32(drd["i_estado"].ToString());
                    obEListarvacacionesxdni.v_estado = drd["v_estado"].ToString();
                    obEListarvacacionesxdni.v_color = drd["v_color"].ToString();
                    obEListarvacacionesxdni.d_fregistro = drd["d_fregistro"].ToString();
                    obEListarvacacionesxdni.d_faprobacion = drd["d_faprobacion"].ToString();
                    lEListarvacacionesxdni.Add(obEListarvacacionesxdni);
                }
                drd.Close();
            }

            return (lEListarvacacionesxdni);
        }
    }
}