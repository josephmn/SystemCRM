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
    public class CListarTipoArchivos
    {
        public List<EListarTipoArchivos> ListarTipoArchivos(SqlConnection con, Int32 post, Int32 id, String mime, String type)
        {
            List<EListarTipoArchivos> lEListarTipoArchivos = null;
            SqlCommand cmd = new SqlCommand("ASP_LISTAR_TIPO_ARCHIVOS", con);
            cmd.CommandType = CommandType.StoredProcedure;

            cmd.Parameters.AddWithValue("@post", SqlDbType.Int).Value = post;
            cmd.Parameters.AddWithValue("@id", SqlDbType.Int).Value = id;
            cmd.Parameters.AddWithValue("@mime", SqlDbType.VarChar).Value = mime;
            cmd.Parameters.AddWithValue("@type", SqlDbType.VarChar).Value = type;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEListarTipoArchivos = new List<EListarTipoArchivos>();

                EListarTipoArchivos obEListarTipoArchivos = null;
                while (drd.Read())
                {
                    obEListarTipoArchivos = new EListarTipoArchivos();
                    obEListarTipoArchivos.i_id = Convert.ToInt32(drd["i_id"].ToString());
                    obEListarTipoArchivos.v_archivo = drd["v_archivo"].ToString();
                    obEListarTipoArchivos.v_mime = drd["v_mime"].ToString();
                    obEListarTipoArchivos.v_type = drd["v_type"].ToString();
                    obEListarTipoArchivos.v_icono = drd["v_icono"].ToString();
                    obEListarTipoArchivos.v_color = drd["v_color"].ToString();
                    obEListarTipoArchivos.d_creacion = drd["d_creacion"].ToString();
                    obEListarTipoArchivos.d_actualizacion = drd["d_actualizacion"].ToString();
                    lEListarTipoArchivos.Add(obEListarTipoArchivos);
                }
                drd.Close();
            }

            return (lEListarTipoArchivos);
        }
    }
}