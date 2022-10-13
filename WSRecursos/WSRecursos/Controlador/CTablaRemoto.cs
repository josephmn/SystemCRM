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
    public class CTablaRemoto
    {
        public List<ETablaRemoto> TablaRemoto(SqlConnection con, Int32 post, String user, Int32 anhio)
        {
            List<ETablaRemoto> lETablaRemoto = null;
            SqlCommand cmd = new SqlCommand("ASP_TABLA_REMOTO", con);
            cmd.CommandType = CommandType.StoredProcedure;

            cmd.Parameters.AddWithValue("@post", SqlDbType.Int).Value = post;
            cmd.Parameters.AddWithValue("@user", SqlDbType.VarChar).Value = user;
            cmd.Parameters.AddWithValue("@anhio", SqlDbType.Int).Value = anhio;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lETablaRemoto = new List<ETablaRemoto>();

                ETablaRemoto obETablaRemoto = null;
                while (drd.Read())
                {
                    obETablaRemoto = new ETablaRemoto();
                    obETablaRemoto.i_id = Convert.ToInt32(drd["i_id"].ToString());
                    obETablaRemoto.v_dni = drd["v_dni"].ToString();
                    obETablaRemoto.i_semana = Convert.ToInt32(drd["i_semana"].ToString());
                    obETablaRemoto.i_mes = Convert.ToInt32(drd["i_mes"].ToString());
                    obETablaRemoto.v_mes = drd["v_mes"].ToString();
                    obETablaRemoto.v_descripcion = drd["v_descripcion"].ToString();
                    obETablaRemoto.i_anhio = Convert.ToInt32(drd["i_anhio"].ToString());
                    obETablaRemoto.i_zona = Convert.ToInt32(drd["i_zona"].ToString());
                    obETablaRemoto.i_local = Convert.ToInt32(drd["i_local"].ToString());
                    obETablaRemoto.i_estado = Convert.ToInt32(drd["i_estado"].ToString());
                    obETablaRemoto.v_estado = drd["v_estado"].ToString();
                    obETablaRemoto.v_color_estado = drd["v_color_estado"].ToString();
                    obETablaRemoto.d_fregistro = drd["d_fregistro"].ToString();
                    obETablaRemoto.d_faprobacion = drd["d_faprobacion"].ToString();
                    lETablaRemoto.Add(obETablaRemoto);
                }
                drd.Close();
            }

            return (lETablaRemoto);
        }
    }
}